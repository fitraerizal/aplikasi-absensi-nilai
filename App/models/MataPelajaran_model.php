<?php

class MataPelajaran_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMataPelajaran()
    {
        // Kita asumsikan hanya ada 1 mata pelajaran
        $this->db->query('SELECT * FROM mata_pelajaran WHERE id_mapel = 1');
        return $this->db->single();
    }

    public function updateMataPelajaran($data)
    {
        $query = "UPDATE mata_pelajaran SET nama_mapel = :nama_mapel WHERE id_mapel = :id_mapel";
        $this->db->query($query);
        $this->db->bind('nama_mapel', $data['nama_mapel']);
        $this->db->bind('id_mapel', $data['id_mapel']);
        $this->db->execute();
        return $this->db->rowCount();
    }
}