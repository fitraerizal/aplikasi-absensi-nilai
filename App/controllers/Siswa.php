<?php

// Tambahkan use statement di atas class Controller
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Siswa extends Controller {

    public function __construct() {
        parent::__construct(); // WAJIB TAMBAHKAN INI
        // Kode lain (jika ada) bisa diletakkan di bawahnya
    }

    public function index()
    {
        $data['judul'] = 'Daftar Siswa';

        $id_kelas_filter = isset($_POST['id_kelas']) ? $_POST['id_kelas'] : null;
        $keyword_search = isset($_POST['keyword']) ? $_POST['keyword'] : null;
        
        $data['id_kelas_aktif'] = $id_kelas_filter;
        $data['keyword_aktif'] = $keyword_search;

        // Kirim filter dan keyword ke model
        $data['siswa'] = $this->model('Siswa_model')->getAllSiswa($id_kelas_filter, $keyword_search);
        
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();
        
        $this->view('templates/header', $data);
        $this->view('siswa/index', $data);
        $this->view('templates/footer');
    }

    // METHOD BARU UNTUK MEMPROSES FORM
    public function proses_tambah()
    {
        // Panggil method tambahDataSiswa di model
        // dan cek apakah data berhasil ditambahkan (rowCount > 0)
        if ($this->model('Siswa_model')->tambahDataSiswa($_POST) > 0) {
            // Jika berhasil, redirect (alihkan) ke halaman daftar siswa
            header('Location: ' . BASEURL . '/siswa');
            exit;
        }
    }

    // METHOD BARU UNTUK MENAMPILKAN FORM
    public function tambah()
    {
        if ($this->model('Siswa_model')->tambahDataSiswa($_POST) > 0) {
            Flasher::setFlash('Data siswa berhasil ditambahkan.', 'success');
        } else {
            Flasher::setFlash('Gagal menambahkan data siswa.', 'danger');
        }
        header('Location: ' . BASEURL . '/siswa');
        exit;
    }

    public function hapus($id)
    {
        if ($this->model('Siswa_model')->hapusDataSiswa($id) > 0) {
            Flasher::setFlash('Data siswa berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Gagal menghapus data siswa.', 'danger');
        }
        header('Location: ' . BASEURL . '/siswa');
        exit;
    }

    public function getubah()
    {
        // Mengembalikan data dalam format JSON
        echo json_encode($this->model('Siswa_model')->getSiswaById($_POST['id']));
    }

    public function ubah()
    {
        if ($this->model('Siswa_model')->updateDataSiswa($_POST) > 0) {
            Flasher::setFlash('Data siswa berhasil diubah.', 'success');
        } else {
            Flasher::setFlash('Gagal mengubah data siswa.', 'danger');
        }
        header('Location: ' . BASEURL . '/siswa');
        exit;
    }

    public function upload()
    {
        // Cek jika file berhasil diupload
        if (isset($_FILES['fileExcel']['name']) && $_FILES['fileExcel']['error'] == 0) {
            $id_kelas = $_POST['id_kelas'];
            $file_tmp = $_FILES['fileExcel']['tmp_name'];
            $file_name = $_FILES['fileExcel']['name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Tentukan reader berdasarkan ekstensi file
            if ($file_ext == 'xlsx') {
                $reader = new Xlsx();
            } else if ($file_ext == 'xls') {
                $reader = new Xls();
            } else {
                Flasher::setFlash('Gagal! Format file tidak didukung.', 'danger');
                header('Location: ' . BASEURL . '/siswa');
                exit;
            }

            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $dataUntukImport = [];
            // Looping dimulai dari baris kedua (indeks 1) untuk melewati header
            for ($i = 1; $i < count($sheetData); $i++) {
                $nama = $sheetData[$i][0]; // Kolom A
                $nis = $sheetData[$i][1]; // Kolom B

                // Pastikan nama dan nis tidak kosong
                if (!empty($nama) && !empty($nis)) {
                    $dataUntukImport[] = [
                        'nama_lengkap' => $nama,
                        'nis' => $nis,
                        'id_kelas' => $id_kelas
                    ];
                }
            }

            if (empty($dataUntukImport)) {
                Flasher::setFlash('Gagal! Tidak ada data valid untuk diimpor.', 'warning');
            } else {
                $jumlahBerhasil = $this->model('Siswa_model')->importDataSiswa($dataUntukImport);
                Flasher::setFlash("Berhasil! Sebanyak $jumlahBerhasil data siswa berhasil diimpor.", 'success');
            }

        } else {
            Flasher::setFlash('Gagal! Tidak ada file yang diupload.', 'danger');
        }

        header('Location: ' . BASEURL . '/siswa');
        exit;
    }
}