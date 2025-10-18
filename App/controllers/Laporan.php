<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends Controller {

    // Method ini akan menampilkan halaman utama Laporan Absensi
    public function absensi()
    {
        $data['judul'] = 'Laporan Absensi';

        // Kita butuh daftar semua kelas untuk ditampilkan
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();

        $this->view('templates/header', $data);
        $this->view('laporan/absensi_index', $data); // View baru yang akan kita buat
        $this->view('templates/footer');
    }

    public function detailAbsensi($id_kelas)
    {
        $data['judul'] = 'Detail Laporan Absensi';

        // 1. Ambil data mentah (tidak ada perubahan)
        $absensi_model = $this->model('Absensi_model');
        $laporan_mentah = $absensi_model->getLaporanAbsensiByKelas($id_kelas);

        // 2. Olah data mentah menjadi format yang siap ditampilkan
        $laporan_terstruktur = [];
        $tanggal_unik = [];
        foreach ($laporan_mentah as $absen) {
            $laporan_terstruktur[$absen['id_siswa']][$absen['tanggal']] = $absen['status'];
            if (!in_array($absen['tanggal'], $tanggal_unik)) {
                $tanggal_unik[] = $absen['tanggal'];
            }
        }

        // ==========================================================
        // TAMBAHAN: Hitung rekapitulasi untuk setiap siswa
        // ==========================================================
        $rekap_per_siswa = [];
        $daftar_siswa = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        foreach ($daftar_siswa as $siswa) {
            $hadir = 0; $sakit = 0; $izin = 0; $alfa = 0;
            if (isset($laporan_terstruktur[$siswa['id_siswa']])) {
                foreach ($laporan_terstruktur[$siswa['id_siswa']] as $status) {
                    if ($status == 'Hadir') $hadir++;
                    if ($status == 'Sakit') $sakit++;
                    if ($status == 'Izin') $izin++;
                    if ($status == 'Alfa') $alfa++;
                }
            }
            $rekap_per_siswa[$siswa['id_siswa']] = [
                'hadir' => $hadir, 'sakit' => $sakit, 'izin' => $izin, 'alfa' => $alfa
            ];
        }
        $data['rekap'] = $rekap_per_siswa;
        // ==========================================================
        
        // 3. Siapkan data lain untuk View (tidak ada perubahan)
        $data['laporan'] = $laporan_terstruktur;
        sort($tanggal_unik);
        $data['tanggal_unik'] = $tanggal_unik;
        $data['kelas'] = $this->model('Kelas_model')->getKelasById($id_kelas);
        $data['siswa'] = $daftar_siswa;

        $this->view('templates/header', $data);
        $this->view('laporan/detail_absensi', $data);
        $this->view('templates/footer');
    }

    public function cetakAbsensi($id_kelas)
    {
        // ==========================================================
        // LANGKAH 1: AMBIL DAN OLAH SEMUA DATA YANG DIBUTUHKAN
        // ==========================================================
        $absensi_model = $this->model('Absensi_model');
        $laporan_mentah = $absensi_model->getLaporanAbsensiByKelas($id_kelas);
        
        // Olah data mentah menjadi format matriks: [id_siswa][tanggal] => status
        $laporan_terstruktur = [];
        $tanggal_unik = [];
        foreach ($laporan_mentah as $absen) {
            $laporan_terstruktur[$absen['id_siswa']][$absen['tanggal']] = $absen['status'];
            if (!in_array($absen['tanggal'], $tanggal_unik)) {
                $tanggal_unik[] = $absen['tanggal'];
            }
        }
        sort($tanggal_unik); // Urutkan tanggal dari yang paling awal

        // Ambil data pendukung
        $kelas = $this->model('Kelas_model')->getKelasById($id_kelas);
        $siswa = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        // Ambil data pengaturan global yang sudah disiapkan oleh Controller Induk
        $pengaturan = $this->global_data['pengaturan'];
        $mapel = $this->global_data['mapel'];

        // ==========================================================
        // LANGKAH 2: BUAT FILE EXCEL MENGGUNAKAN PHPSPREADSHEET
        // ==========================================================
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- TULIS HEADER DAN INFORMASI LAPORAN ---
        $sheet->setCellValue('A1', 'LAPORAN ABSENSI SISWA');
        $sheet->setCellValue('A2', strtoupper($pengaturan['nama_sekolah']));
        $sheet->setCellValue('A6', 'Guru Pengampu: ' . $pengaturan['nama_guru_pengampu']);
        $sheet->getStyle('A6')->getFont()->setBold(true);
        $sheet->setCellValue('A3', 'Mata Pelajaran: ' . strtoupper($mapel['nama_mapel']));
        $sheet->setCellValue('A4', 'Kelas: ' . $kelas['nama_kelas']);
        $sheet->setCellValue('A5', 'Tahun Ajaran: ' . $pengaturan['tahun_ajaran'] . ' | Semester: ' . $pengaturan['semester']);
        
        // Styling untuk header
        $sheet->mergeCells('A1:G1'); $sheet->mergeCells('A2:G2'); $sheet->mergeCells('A3:G3'); $sheet->mergeCells('A4:G4'); $sheet->mergeCells('A5:G5');
        $sheet->getStyle('A1:A5')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:A5')->getAlignment()->setHorizontal('center');

        // --- TULIS HEADER TABEL ---
        $header_row = 7;
        $sheet->setCellValue('A' . $header_row, 'Nama Siswa');
        $col_char = 'B';
        foreach ($tanggal_unik as $tanggal) {
            $sheet->setCellValue($col_char . $header_row, date('d/m/Y', strtotime($tanggal)));
            $col_char++;
        }
        
        // Tulis header untuk kolom rekapitulasi
        $start_rekap_col = $col_char;
        $sheet->setCellValue($col_char++ . $header_row, 'Hadir');
        $sheet->setCellValue($col_char++ . $header_row, 'Sakit');
        $sheet->setCellValue($col_char++ . $header_row, 'Izin');
        $sheet->setCellValue($col_char++ . $header_row, 'Alfa');
        
        // Styling untuk header tabel
        $last_col = $sheet->getHighestColumn();
        $sheet->getStyle('A'.$header_row.':'.$last_col.$header_row)->getFont()->setBold(true);
        $sheet->getStyle('A'.$header_row.':'.$last_col.$header_row)->getAlignment()->setHorizontal('center');

        // --- TULIS DATA ABSENSI DAN LAKUKAN PERHITUNGAN ---
        $current_row = $header_row + 1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A' . $current_row, $s['nama_lengkap']);
            
            // Inisialisasi penghitung untuk setiap siswa
            $hadir = 0; $sakit = 0; $izin = 0; $alfa = 0;
            
            $col_char = 'B';
            foreach ($tanggal_unik as $tanggal) {
                $status = $laporan_terstruktur[$s['id_siswa']][$tanggal] ?? '-';
                $sheet->setCellValue($col_char . $current_row, $status);
                $sheet->getStyle($col_char . $current_row)->getAlignment()->setHorizontal('center');
                
                // Lakukan perhitungan status
                if ($status == 'Hadir') $hadir++;
                if ($status == 'Sakit') $sakit++;
                if ($status == 'Izin') $izin++;
                if ($status == 'Alfa') $alfa++;
                
                $col_char++;
            }

            // Tulis hasil perhitungan di kolom rekapitulasi
            $rekap_col_char = $start_rekap_col;
            $sheet->setCellValue($rekap_col_char++ . $current_row, $hadir);
            $sheet->setCellValue($rekap_col_char++ . $current_row, $sakit);
            $sheet->setCellValue($rekap_col_char++ . $current_row, $izin);
            $sheet->setCellValue($rekap_col_char++ . $current_row, $alfa);
            $sheet->getStyle($start_rekap_col.$current_row.':'.$last_col.$current_row)->getAlignment()->setHorizontal('center');

            $current_row++;
        }
        
        // --- ATUR LEBAR KOLOM OTOMATIS ---
        foreach (range('A', $last_col) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // ==========================================================
        // LANGKAH 3: KIRIM FILE KE BROWSER UNTUK DIUNDUH
        // ==========================================================
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Absensi - ' . $kelas['nama_kelas'] . ' - ' . date('d-m-Y') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function nilai()
    {
        $data['judul'] = 'Laporan Nilai';

        // Ambil daftar semua kelas untuk ditampilkan
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();

        $this->view('templates/header', $data);
        $this->view('laporan/nilai_index', $data); // View baru yang akan kita buat
        $this->view('templates/footer');
    }

    public function detailNilai($id_kelas)
    {
        $data['judul'] = 'Detail Laporan Nilai';

        // 1. Ambil semua data yang dibutuhkan (tidak ada perubahan)
        $data['kelas'] = $this->model('Kelas_model')->getKelasById($id_kelas);
        $data['siswa'] = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        $data['tugas'] = $this->model('Tugas_model')->getTugasByIdKelas($id_kelas);
        $nilai_mentah = $this->model('Nilai_model')->getNilaiByIdKelas($id_kelas);
        
        // 2. Olah data nilai mentah menjadi format matriks (tidak ada perubahan)
        $laporan_nilai = [];
        foreach ($nilai_mentah as $nilai) {
            $laporan_nilai[$nilai['id_siswa']][$nilai['id_tugas']] = $nilai['nilai'];
        }
        $data['laporan_nilai'] = $laporan_nilai;

        // ==========================================================
        // TAMBAHAN: Hitung rata-rata untuk setiap siswa
        // ==========================================================
        $rata_rata_siswa = [];
        foreach ($data['siswa'] as $siswa) {
            // Cek apakah siswa ini punya nilai
            if (isset($laporan_nilai[$siswa['id_siswa']])) {
                $nilai_siswa = $laporan_nilai[$siswa['id_siswa']];
                $total_nilai = array_sum($nilai_siswa);
                $jumlah_nilai = count($nilai_siswa);
                $rata_rata = $total_nilai / $jumlah_nilai;
                // Simpan rata-rata yang sudah dibulatkan
                $rata_rata_siswa[$siswa['id_siswa']] = round($rata_rata, 2);
            } else {
                // Jika siswa belum punya nilai sama sekali
                $rata_rata_siswa[$siswa['id_siswa']] = '-';
            }
        }
        $data['rata_rata'] = $rata_rata_siswa;
        // ==========================================================

        $this->view('templates/header', $data);
        $this->view('laporan/detail_nilai', $data);
        $this->view('templates/footer');
    }

    public function cetakNilai($id_kelas)
    {
        // 1. Ambil dan olah semua data yang dibutuhkan
        $kelas = $this->model('Kelas_model')->getKelasById($id_kelas);
        $siswa = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        $tugas = $this->model('Tugas_model')->getTugasByIdKelas($id_kelas);
        $nilai_mentah = $this->model('Nilai_model')->getNilaiByIdKelas($id_kelas);
        $pengaturan = $this->global_data['pengaturan'];
        $mapel = $this->global_data['mapel'];
        
        $laporan_nilai = [];
        foreach ($nilai_mentah as $nilai) {
            $laporan_nilai[$nilai['id_siswa']][$nilai['id_tugas']] = $nilai['nilai'];
        }

        // ==========================================================
        // TAMBAHAN: Hitung rata-rata untuk setiap siswa (logika yang sama dari detailNilai)
        // ==========================================================
        $rata_rata_siswa = [];
        foreach ($siswa as $s) {
            if (isset($laporan_nilai[$s['id_siswa']])) {
                $nilai_siswa = $laporan_nilai[$s['id_siswa']];
                $rata_rata = array_sum($nilai_siswa) / count($nilai_siswa);
                $rata_rata_siswa[$s['id_siswa']] = round($rata_rata, 2);
            } else {
                $rata_rata_siswa[$s['id_siswa']] = '-';
            }
        }

        // 2. Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 3. Tulis Header Laporan (tidak ada perubahan)
        // ... (kode header seperti sebelumnya) ...
        $sheet->setCellValue('A1', 'LAPORAN NILAI SISWA');
        $sheet->setCellValue('A2', strtoupper($pengaturan['nama_sekolah']));
        $sheet->setCellValue('A6', 'Guru Pengampu: ' . $pengaturan['nama_guru_pengampu']);
        $sheet->getStyle('A6')->getFont()->setBold(true);
        $sheet->setCellValue('A3', 'Mata Pelajaran: ' . strtoupper($mapel['nama_mapel']));
        $sheet->setCellValue('A4', 'Kelas: ' . $kelas['nama_kelas']);
        $sheet->setCellValue('A5', 'Tahun Ajaran: ' . $pengaturan['tahun_ajaran'] . ' | Semester: ' . $pengaturan['semester']);
        $sheet->mergeCells('A1:G1'); $sheet->mergeCells('A2:G2'); $sheet->mergeCells('A3:G3'); $sheet->mergeCells('A4:G4'); $sheet->mergeCells('A5:G5');
        $sheet->getStyle('A1:A5')->getFont()->setBold(true);
        $sheet->getStyle('A1:A5')->getAlignment()->setHorizontal('center');

        // 4. Tulis Header Tabel
        $header_row = 7;
        $sheet->setCellValue('A' . $header_row, 'Nama Siswa');
        $col_char = 'B';
        foreach ($tugas as $t) {
            $sheet->setCellValue($col_char . $header_row, $t['nama_tugas']);
            $col_char++;
        }
        // Tambahkan header untuk kolom Rata-Rata
        $sheet->setCellValue($col_char . $header_row, 'Rata-Rata');
        
        // Styling header
        // ... (kode styling header) ...

        // 5. Tulis Data Nilai
        $current_row = $header_row + 1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A' . $current_row, $s['nama_lengkap']);
            $col_char = 'B';
            foreach ($tugas as $t) {
                $nilai = $laporan_nilai[$s['id_siswa']][$t['id_tugas']] ?? '-';
                $sheet->setCellValue($col_char . $current_row, $nilai);
                $sheet->getStyle($col_char . $current_row)->getAlignment()->setHorizontal('center');
                $col_char++;
            }
            // ==========================================================
            // TAMBAHAN: Tulis nilai rata-rata di kolom terakhir
            // ==========================================================
            $sheet->setCellValue($col_char . $current_row, $rata_rata_siswa[$s['id_siswa']]);
            $sheet->getStyle($col_char . $current_row)->getFont()->setBold(true);
            $sheet->getStyle($col_char . $current_row)->getAlignment()->setHorizontal('center');
            // ==========================================================
            
            $current_row++;
        }
        
        // 6. Atur lebar kolom otomatis
        foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 7. Kirim file ke browser
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Nilai - ' . $kelas['nama_kelas'] . ' - ' . date('d-m-Y') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

}