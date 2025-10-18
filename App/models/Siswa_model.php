<?php

class Siswa_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

 
    // METHOD BARU UNTUK MENAMBAH DATA
     public function tambahDataSiswa($data)
    {
        $query = "INSERT INTO siswa (nama_lengkap, nis, id_kelas) 
                  VALUES (:nama_lengkap, :nis, :id_kelas)";
        
        $this->db->query($query);
        $this->db->bind('nama_lengkap', $data['nama_lengkap']);
        $this->db->bind('nis', $data['nis']);
        $this->db->bind('id_kelas', $data['id_kelas']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    /**
     * Mengambil semua data siswa, bisa difilter berdasarkan kelas.
     * @param int|null $id_kelas ID kelas untuk filter.
     */
    public function getAllSiswa($id_kelas = null, $keyword = null)
    {
        $query = "SELECT siswa.*, kelas.nama_kelas 
                  FROM siswa 
                  JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                  WHERE 1"; // WHERE 1 untuk klausa awal yang netral

        $params = [];

        if ($id_kelas) {
            $query .= " AND siswa.id_kelas = :id_kelas";
            $params[':id_kelas'] = $id_kelas;
        }

        if ($keyword) {
            $query .= " AND siswa.nama_lengkap LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }
        
        $query .= " ORDER BY kelas.nama_kelas, siswa.nama_lengkap ASC";
        
        $this->db->query($query);

        foreach ($params as $key => &$val) {
            $this->db->bind($key, $val);
        }
        
        return $this->db->resultSet();
    }

    public function getSiswaByIdKelas($id_kelas)
    {
        $this->db->query('SELECT * FROM siswa WHERE id_kelas = :id_kelas ORDER BY nama_lengkap ASC');
        $this->db->bind('id_kelas', $id_kelas);
        return $this->db->resultSet();
    }

    public function hapusDataSiswa($id)
    {
        $query = "DELETE FROM siswa WHERE id_siswa = :id_siswa";
        $this->db->query($query);
        $this->db->bind('id_siswa', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getSiswaById($id)
    {
        $this->db->query('SELECT * FROM siswa WHERE id_siswa = :id_siswa');
        $this->db->bind('id_siswa', $id);
        return $this->db->single();
    }

    public function updateDataSiswa($data)
    {
        $query = "UPDATE siswa SET 
                    nama_lengkap = :nama_lengkap,
                    nis = :nis,
                    id_kelas = :id_kelas
                  WHERE id_siswa = :id_siswa";
        
        $this->db->query($query);
        $this->db->bind('nama_lengkap', $data['nama_lengkap']);
        $this->db->bind('nis', $data['nis']);
        $this->db->bind('id_kelas', $data['id_kelas']);
        $this->db->bind('id_siswa', $data['id_siswa']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function importDataSiswa($dataSiswa)
    {
        $berhasil = 0;
        foreach ($dataSiswa as $siswa) {
            $this->db->query("INSERT INTO siswa (nama_lengkap, nis, id_kelas) VALUES (:nama_lengkap, :nis, :id_kelas)");
            $this->db->bind('nama_lengkap', $siswa['nama_lengkap']);
            $this->db->bind('nis', $siswa['nis']);
            $this->db->bind('id_kelas', $siswa['id_kelas']);
            
            // Menggunakan try-catch untuk melewati data dengan NIS duplikat
            try {
                $this->db->execute();
                $berhasil++;
            } catch (PDOException $e) {
                // Abaikan error (misal: duplicate entry) dan lanjutkan
                continue;
            }
        }
        return $berhasil;
    }
}