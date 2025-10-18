<?php
// Pastikan tidak ada spasi atau teks apa pun sebelum tag <?php
if (!session_id()) {
    session_start();
}

// Memuat file bootstraping utama aplikasi
require_once dirname(__DIR__) . '/App/init.php';

// Membuat objek dari kelas App (router utama kita)
$app = new App;