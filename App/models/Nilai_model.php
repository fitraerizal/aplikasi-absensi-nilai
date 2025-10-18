<?php

class Nilai_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Mengambil semua data nilai milik siswa di kelas tertentu
    public function getNilaiByIdKelas($id_kelas)
    {
        $query = "SELECT nilai.*, siswa.nama_lengkap 
                  FROM nilai 
                  JOIN siswa ON nilai.id_siswa = siswa.id_siswa
                  WHERE siswa.id_kelas = :id_kelas
                  ORDER BY siswa.nama_lengkap, nilai.tanggal_penilaian DESC";
        
        $this->db->query($query);
        $this->db->bind('id_kelas', $id_kelas);
        return $this->db->resultSet();
    }

    public function tambahDataNilai($data)
    {
        $query = "INSERT INTO nilai (id_siswa, jenis_penilaian, deskripsi, nilai, tanggal_penilaian) 
                  VALUES (:id_siswa, :jenis_penilaian, :deskripsi, :nilai, :tanggal_penilaian)";
        
        $this->db->query($query);
        $this->db->bind('id_siswa', $data['id_siswa']);
        $this->db->bind('jenis_penilaian', $data['jenis_penilaian']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('nilai', $data['nilai']);
        $this->db->bind('tanggal_penilaian', $data['tanggal_penilaian']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    // Tambahkan method ini di dalam class Nilai_model
    public function simpanNilaiMassal($data)
    {
        // Query ini akan meng-insert baris baru, atau meng-update nilai 
        // jika data untuk siswa & tugas tersebut sudah ada (berdasarkan UNIQUE key).
        $query = "INSERT INTO nilai (id_siswa, id_tugas, nilai, tanggal_penilaian) 
                  VALUES (:id_siswa, :id_tugas, :nilai, CURDATE())
                  ON DUPLICATE KEY UPDATE nilai = :nilai_update";

        $berhasil = 0;
        foreach($data['nilai'] as $id_siswa => $nilai) {
            // Hanya simpan jika kolom nilai tidak kosong
            if ($nilai !== '' && !is_null($nilai)) {
                $this->db->query($query);
                $this->db->bind('id_siswa', $id_siswa);
                $this->db->bind('id_tugas', $data['id_tugas']);
                $this->db->bind('nilai', $nilai);
                $this->db->bind('nilai_update', $nilai);
                $this->db->execute();
                $berhasil++;
            }
        }
        return $berhasil;
    }

    public function getNilaiByTugasId($id_tugas)
    {
        $query = "SELECT nilai.*, siswa.nama_lengkap, siswa.nis 
                  FROM nilai 
                  JOIN siswa ON nilai.id_siswa = siswa.id_siswa
                  WHERE nilai.id_tugas = :id_tugas
                  ORDER BY siswa.nama_lengkap ASC";
        
        $this->db->query($query);
        $this->db->bind('id_tugas', $id_tugas);
        return $this->db->resultSet();
    }
}