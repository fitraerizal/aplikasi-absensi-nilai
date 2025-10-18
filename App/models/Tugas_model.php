<?php

class Tugas_model {
    private $db;

    public function __construct()
    {
        // Membuat object dari class Database untuk koneksi
        $this->db = new Database;
    }

    /**
     * Mengambil semua data tugas yang ada, digabung dengan nama kelasnya.
     * @return array Daftar semua tugas.
     */
    public function getAllTugas($id_kelas = null)
    {
        $query = "SELECT tugas.*, kelas.nama_kelas
                  FROM tugas
                  JOIN kelas ON tugas.id_kelas = kelas.id_kelas";

        // Jika ada id_kelas yang dikirim, tambahkan kondisi WHERE
        if ($id_kelas) {
            $query .= " WHERE tugas.id_kelas = :id_kelas";
        }
        
        $query .= " ORDER BY tanggal_tugas DESC";
        
        $this->db->query($query);

        // Bind parameter hanya jika id_kelas ada
        if ($id_kelas) {
            $this->db->bind('id_kelas', $id_kelas);
        }
        
        return $this->db->resultSet();
    }

    /**
     * Mengambil detail satu tugas spesifik berdasarkan ID-nya.
     * @param int $id ID tugas.
     * @return array Data tugas tunggal.
     */
    public function getTugasById($id)
    {
        $this->db->query('SELECT * FROM tugas WHERE id_tugas = :id_tugas');
        $this->db->bind('id_tugas', $id);
        return $this->db->single();
    }

    /**
     * Mengambil semua tugas yang dimiliki oleh kelas tertentu.
     * Ini digunakan untuk fitur AJAX dropdown.
     * @param int $id_kelas ID kelas.
     * @return array Daftar tugas untuk kelas tersebut.
     */
    public function getTugasByIdKelas($id_kelas)
    {
        $this->db->query("SELECT * FROM tugas WHERE id_kelas = :id_kelas ORDER BY tanggal_tugas DESC");
        $this->db->bind('id_kelas', $id_kelas);
        return $this->db->resultSet();
    }

    /**
     * Menambah data tugas baru ke database.
     * @param array $data Data dari form ($_POST).
     * @return int Jumlah baris yang berhasil ditambahkan.
     */
    public function tambahTugas($data)
    {
        $query = "INSERT INTO tugas (id_kelas, nama_tugas, deskripsi, tanggal_tugas)
                  VALUES (:id_kelas, :nama_tugas, :deskripsi, :tanggal_tugas)";
        
        $this->db->query($query);
        $this->db->bind('id_kelas', $data['id_kelas']);
        $this->db->bind('nama_tugas', $data['nama_tugas']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('tanggal_tugas', $data['tanggal_tugas']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusTugas($id)
    {
        $query = "DELETE FROM tugas WHERE id_tugas = :id_tugas";
        
        $this->db->query($query);
        $this->db->bind('id_tugas', $id);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}