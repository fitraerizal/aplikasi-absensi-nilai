<?php

class Home extends Controller {

    public function __construct() {
        parent::__construct(); 
    }
    
    public function index()
    {
        $data['judul'] = 'Halaman Utama';
        $absensi_model = $this->model('Absensi_model');
        
        // ==========================================================
        // LOGIKA BARU: MENENTUKAN NILAI FILTER
        // ==========================================================
        
        // Untuk filter harian: gunakan tanggal dari form, atau tanggal absen terakhir jika tidak ada.
        $data['tanggal_aktif'] = $_POST['filter_tanggal'] ?? $absensi_model->getTanggalAbsenTerakhir();
        
        // Untuk filter bulanan: gunakan bulan dari form, atau bulan ini jika tidak ada.
        $bulan_tahun_aktif = $_POST['filter_bulan'] ?? date('Y-m');
        $data['bulan_aktif'] = $bulan_tahun_aktif;
        // Pisahkan tahun dan bulan untuk dikirim ke model
        list($tahun, $bulan) = explode('-', $bulan_tahun_aktif);

        // ==========================================================
        // LOGIKA BARU: MENGAMBIL DATA STATISTIK
        // ==========================================================
        
        // Ambil statistik berdasarkan filter yang sudah ditentukan.
        $data['statistik_harian'] = $absensi_model->getStatistikPerTanggal($data['tanggal_aktif']);
        $data['statistik_bulanan'] = $absensi_model->getStatistikPerBulan($bulan, $tahun);
        
        // Kirim data ke view
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}