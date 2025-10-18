<?php

class Controller {
    // Properti untuk menyimpan data global
    protected $global_data = [];

    public function __construct()
    {
        // Cukup muat model sekali saja
        $mapel_model = $this->model('MataPelajaran_model');
        @$this->global_data['mapel'] = $mapel_model->getMataPelajaran();

        $pengaturan_model = $this->model('Pengaturan_model');
        @$this->global_data['pengaturan'] = $pengaturan_model->getAllPengaturan();
    }

    /**
     * Method untuk memuat file view.
     */
    public function view($view, $data = [])
    {
        // Gabungkan data global dengan data spesifik halaman
        $data = array_merge($this->global_data, $data);
        
        // Kirim data yang sudah digabung ke view
        require_once dirname(__DIR__) . '/Views/' . $view . '.php';
    }

    /**
     * Method untuk memuat file model.
     */
    public function model($model)
    {
        // Path ini sudah benar, asalkan nama folder di server adalah 'models' (huruf kecil)
        require_once dirname(__DIR__) . '/models/' . $model . '.php';
        return new $model;
    }
}