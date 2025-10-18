<?php

class Nilai extends Controller {

    public function __construct() {
        parent::__construct(); // WAJIB TAMBAHKAN INI
        // Kode lain (jika ada) bisa diletakkan di bawahnya
    }
    
    // Method ini menampilkan halaman dasbor nilai
    public function index()
    {
        $data['judul'] = 'Pengelolaan Nilai';

        // Cek apakah ada filter kelas yang dikirim dari form
        $id_kelas_filter = isset($_POST['id_kelas']) ? $_POST['id_kelas'] : null;
        
        // Kirim id_kelas yang aktif ke view agar dropdown bisa 'mengingat' pilihan
        $data['id_kelas_aktif'] = $id_kelas_filter;
        
        // Ambil daftar kelas untuk dropdown filter
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();
        
        // Ambil daftar tugas (semua atau yang sudah difilter)
        $data['tugas'] = $this->model('Tugas_model')->getAllTugas($id_kelas_filter);
        
        $this->view('templates/header', $data);
        $this->view('nilai/index', $data);
        $this->view('templates/footer');
    }

    // Method ini memproses form dari modal "Buat Tugas Baru"
    public function tambahTugas()
    {
        if($this->model('Tugas_model')->tambahTugas($_POST) > 0) {
            Flasher::setFlash('Tugas baru berhasil dibuat.', 'success');
        } else {
            Flasher::setFlash('Gagal membuat tugas baru.', 'danger');
        }
        header('Location: ' . BASEURL . '/nilai');
        exit;
    }

    public function kelas()
    {
        // Ambil ID kelas dari form sebelumnya
        $id_kelas = $_POST['id_kelas'];

        $data['judul'] = 'Detail Nilai Kelas';
        // Ambil data spesifik kelas (untuk judul halaman)
        $data['detail_kelas'] = $this->model('Kelas_model')->getKelasById($id_kelas);
        // Ambil daftar siswa di kelas tersebut (untuk dropdown form)
        $data['siswa'] = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        // Ambil semua riwayat nilai di kelas tersebut (untuk tabel)
        $data['nilai_kelas'] = $this->model('Nilai_model')->getNilaiByIdKelas($id_kelas);
        
        $this->view('templates/header', $data);
        $this->view('nilai/kelas', $data); // View baru yang akan kita buat
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->model('Nilai_model')->tambahDataNilai($_POST) > 0) {
            Flasher::setFlash('Nilai berhasil ditambahkan.', 'success');
        } else {
            Flasher::setFlash('Gagal menambahkan nilai.', 'danger');
        }
        // Redirect kembali ke halaman nilai (pengguna harus memilih kelas lagi)
        header('Location: ' . BASEURL . '/nilai');
        exit;
    }

    public function getTugasByKelas()
    {
        // Method ini khusus untuk AJAX
        $id_kelas = $_POST['id_kelas'];
        $tugas = $this->model('Tugas_model')->getTugasByIdKelas($id_kelas);
        echo json_encode($tugas);
    }

    public function pilihTugas()
    {
        $data['judul'] = 'Pilih Tugas';
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();
        $this->view('templates/header', $data);
        $this->view('nilai/pilih_tugas', $data);
        $this->view('templates/footer');
    }

    public function inputMassal($id_tugas, $id_kelas)
    {
        $data['judul'] = 'Input Nilai';
        $data['tugas'] = $this->model('Tugas_model')->getTugasById($id_tugas);
        $data['kelas'] = $this->model('Kelas_model')->getKelasById($id_kelas);
        $data['siswa'] = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        
        $this->view('templates/header', $data);
        $this->view('nilai/input_massal', $data);
        $this->view('templates/footer');
    }

    public function simpanMassal()
    {
        if($this->model('Nilai_model')->simpanNilaiMassal($_POST) > 0) {
            Flasher::setFlash('Nilai siswa berhasil disimpan.', 'success');
        } else {
            Flasher::setFlash('Tidak ada data nilai baru yang disimpan.', 'warning');
        }
        header('Location: ' . BASEURL . '/nilai');
        exit;
    }

    public function lihat($id_tugas)
    {
        $data['judul'] = 'Lihat Nilai Tugas';
        
        // TAMBAHKAN $this-> PADA SEMUA PEMANGGILAN METHOD
        $data['tugas'] = $this->model('Tugas_model')->getTugasById($id_tugas);
        $data['kelas'] = $this->model('Kelas_model')->getKelasById($data['tugas']['id_kelas']);
        $data['daftar_nilai'] = $this->model('Nilai_model')->getNilaiByTugasId($id_tugas);
    
        $this->view('templates/header', $data);
        $this->view('nilai/lihat_nilai', $data);
        $this->view('templates/footer');
    }

    public function editNilai($id_tugas)
    {
        $data['judul'] = 'Edit Nilai';
        
        // Ambil data yang dibutuhkan
        $data['tugas'] = $this->model('Tugas_model')->getTugasById($id_tugas);
        $data['kelas'] = $this->model('Kelas_model')->getKelasById($data['tugas']['id_kelas']);
        $data['siswa'] = $this->model('Siswa_model')->getSiswaByIdKelas($data['tugas']['id_kelas']);
        $nilai_yang_ada = $this->model('Nilai_model')->getNilaiByTugasId($id_tugas);
        
        // Olah data nilai agar mudah diakses di view
        $nilai_terformat = [];
        foreach($nilai_yang_ada as $nilai) {
            $nilai_terformat[$nilai['id_siswa']] = $nilai['nilai'];
        }
        $data['nilai_siswa'] = $nilai_terformat;

        $this->view('templates/header', $data);
        $this->view('nilai/edit_nilai', $data); // View baru yang akan kita buat
        $this->view('templates/footer');
    }

    public function updateMassal()
    {
        // Method simpanNilaiMassal bisa kita gunakan lagi karena query-nya (ON DUPLICATE KEY UPDATE)
        // sudah dirancang untuk bisa meng-update data yang ada.
        if($this->model('Nilai_model')->simpanNilaiMassal($_POST) > 0) {
            Flasher::setFlash('Nilai siswa berhasil diperbarui.', 'success');
        } else {
            Flasher::setFlash('Tidak ada data nilai yang diubah.', 'warning');
        }
        header('Location: ' . BASEURL . '/nilai');
        exit;
    }

    public function hapusTugas($id_tugas)
    {
        if ($this->model('Tugas_model')->hapusTugas($id_tugas) > 0) {
            Flasher::setFlash('Tugas berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Gagal menghapus tugas.', 'danger');
        }
        header('Location: ' . BASEURL . '/nilai');
        exit;
    }
}