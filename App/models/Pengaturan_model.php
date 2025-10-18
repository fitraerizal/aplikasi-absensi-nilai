<?php

class Pengaturan_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Mengambil semua data pengaturan
    public function getAllPengaturan()
    {
        $this->db->query("SELECT * FROM pengaturan");
        $results = $this->db->resultSet();

        // Mengubah array menjadi format key => value
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    // Memperbarui beberapa pengaturan sekaligus
    public function updatePengaturan($data)
    {
        $query = "UPDATE pengaturan SET setting_value = :setting_value WHERE setting_key = :setting_key";
        $berhasil = 0;
        foreach ($data as $key => $value) {
            if ($key == 'submit') continue; // Lewati tombol submit
            $this->db->query($query);
            $this->db->bind('setting_key', $key);
            $this->db->bind('setting_value', $value);
            $this->db->execute();
            $berhasil += $this->db->rowCount();
        }
        return $berhasil;
    }
}