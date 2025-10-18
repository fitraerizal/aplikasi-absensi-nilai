<?php

class App {
    // Properti untuk menentukan controller, method, dan parameter default
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // --- Mengelola Controller ---
        // Cek apakah ada controller yang sesuai dengan nama di URL
        
        if (isset($url[0]) && file_exists('../App/controllers/' . ucfirst($url[0]) . '.php')) {
            // Jika ada, timpa controller default dengan yang baru
            $this->controller = ucfirst($url[0]);
            // Hapus nama controller dari array URL agar tersisa method dan parameter
            unset($url[0]);
        }
        
        // Muat file controller yang telah ditentukan
        require_once '../App/controllers/' . $this->controller . '.php';
        // Buat objek dari kelas controller tersebut
        $this->controller = new $this->controller;

        // --- Mengelola Method ---
        // Cek apakah ada method yang dikirim di URL
        if (isset($url[1])) {
            // Cek apakah method tersebut ada di dalam controller
            if (method_exists($this->controller, $url[1])) {
                // Jika ada, timpa method default
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // --- Mengelola Parameter ---
        // Jika masih ada sisa dari array URL, itu adalah parameter
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // --- Jalankan Controller & Method ---
        // Jalankan controller dan method yang sudah ditentukan, 
        // serta kirimkan parameter jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Method untuk mengambil dan membersihkan URL.
     */
    public function parseURL() {
        if (isset($_GET['url'])) {
            // Menghapus tanda '/' di akhir URL
            $url = rtrim($_GET['url'], '/');
            // Membersihkan URL dari karakter-karakter berbahaya
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Memecah URL berdasarkan tanda '/' menjadi sebuah array
            $url = explode('/', $url);
            return $url;
        }
        // Jika tidak ada URL, kembalikan array kosong
        return [];
    }
}