<?php

class Kelas_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllKelas()
    {
        $this->db->query('SELECT * FROM kelas ORDER BY nama_kelas ASC');
        return $this->db->resultSet();
    }


    public function tambahDataKelas($data)
    {
        $query = "INSERT INTO kelas (nama_kelas) VALUES (:nama_kelas)";
        $this->db->query($query);
        $this->db->bind('nama_kelas', $data['nama_kelas']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    public function hapusDataKelas($id)
    {
        $query = "DELETE FROM kelas WHERE id_kelas = :id_kelas";
        $this->db->query($query);
        $this->db->bind('id_kelas', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    /**
     * Mengambil satu data kelas berdasarkan ID.
     * @param int $id ID kelas.
     * @return array Data kelas tunggal.
     */
    public function getKelasById($id)
    {
        $this->db->query('SELECT * FROM kelas WHERE id_kelas = :id_kelas');
        $this->db->bind('id_kelas', $id);
        return $this->db->single();
    }

    /**
     * Mengubah data kelas di database.
     * @param array $data Data dari form ($_POST).
     * @return int Jumlah baris yang terpengaruh.
     */
    public function updateDataKelas($data)
    {
        $query = "UPDATE kelas SET nama_kelas = :nama_kelas WHERE id_kelas = :id_kelas";
        
        $this->db->query($query);
        $this->db->bind('nama_kelas', $data['nama_kelas']);
        $this->db->bind('id_kelas', $data['id_kelas']);

        $this->db->execute();
        return $this->db->rowCount();
    }
}