<?php

class Pengaturan extends Controller {

    public function __construct() {
        parent::__construct(); // WAJIB TAMBAHKAN INI
        // Kode lain (jika ada) bisa diletakkan di bawahnya
    }
    
    public function index()
    {
        $data['judul'] = 'Pengaturan';
        
        // Ambil data kelas
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();
        // Ambil data mata pelajaran
        $data['mapel'] = $this->model('MataPelajaran_model')->getMataPelajaran();
        // ==========================================================
        // TAMBAHAN: Ambil data pengaturan umum (nama sekolah, dll.)
        // ==========================================================
        $data['pengaturan'] = $this->model('Pengaturan_model')->getAllPengaturan();
        
        $this->view('templates/header', $data);
        $this->view('pengaturan/index', $data);
        $this->view('templates/footer');
    }

    // ==========================================================
    // METHOD BARU: Untuk menyimpan perubahan dari form pengaturan umum
    // ==========================================================
    public function update()
    {
        if ($this->model('Pengaturan_model')->updatePengaturan($_POST) > 0) {
            Flasher::setFlash('Pengaturan umum berhasil diperbarui.', 'success');
        } else {
            Flasher::setFlash('Tidak ada perubahan yang disimpan.', 'info');
        }
        header('Location: ' . BASEURL . '/pengaturan');
        exit;
    }

    // METHOD-METHOD DI BAWAH INI TETAP SAMA (TIDAK ADA PERUBAHAN)
    public function tambahKelas()
    {
        if ($this->model('Kelas_model')->tambahDataKelas($_POST) > 0) {
            Flasher::setFlash('Kelas berhasil ditambahkan', 'success');
        } else {
            Flasher::setFlash('Gagal menambahkan kelas', 'danger');
        }
        header('Location: ' . BASEURL . '/pengaturan');
        exit;
    }

    public function hapusKelas($id)
    {
        if ($this->model('Kelas_model')->hapusDataKelas($id) > 0) {
            Flasher::setFlash('Kelas berhasil dihapus', 'success');
        } else {
            Flasher::setFlash('Gagal menghapus kelas', 'danger');
        }
        header('Location: ' . BASEURL . '/pengaturan');
        exit;
    }

    public function editKelas($id)
    {
        $data['judul'] = 'Edit Kelas';
        $data['kelas'] = $this->model('Kelas_model')->getKelasById($id);
        
        $this->view('templates/header', $data);
        $this->view('pengaturan/edit_kelas', $data);
        $this->view('templates/footer');
    }

    public function updateKelas()
    {
        if ($this->model('Kelas_model')->updateDataKelas($_POST) > 0) {
            Flasher::setFlash('Data kelas berhasil diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal memperbarui data kelas', 'danger');
        }
        header('Location: ' . BASEURL . '/pengaturan');
        exit;
    }

    public function updateMapel()
    {
        if ($this->model('MataPelajaran_model')->updateMataPelajaran($_POST) > 0) {
            Flasher::setFlash('Nama mata pelajaran berhasil diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal memperbarui nama mata pelajaran', 'danger');
        }
        header('Location: ' . BASEURL . '/pengaturan');
        exit;
    }

    
}