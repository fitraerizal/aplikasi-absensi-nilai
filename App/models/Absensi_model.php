<?php

class Absensi_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Menyimpan data absensi dari form massal.
     */
    public function simpanAbsensi($data)
    {
        $tanggal = $data['tanggal'];
        $id_kelas = $data['id_kelas'];

        // Hapus data absensi lama pada tanggal & kelas yang sama untuk mencegah duplikasi
        $queryDelete = "DELETE FROM absensi WHERE tanggal = :tanggal AND id_siswa IN (SELECT id_siswa FROM siswa WHERE id_kelas = :id_kelas)";
        $this->db->query($queryDelete);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('id_kelas', $id_kelas);
        $this->db->execute();

        $queryInsert = "INSERT INTO absensi (id_siswa, tanggal, status) VALUES (:id_siswa, :tanggal, :status)";
        
        $total_berhasil = 0;
        if (isset($data['id_siswa']) && is_array($data['id_siswa'])) {
            foreach ($data['id_siswa'] as $id_siswa) {
                $status = $data['status'][$id_siswa];
                
                $this->db->query($queryInsert);
                $this->db->bind('id_siswa', $id_siswa);
                $this->db->bind('tanggal', $tanggal);
                $this->db->bind('status', $status);
                $this->db->execute();
                
                $total_berhasil += $this->db->rowCount();
            }
        }
        return $total_berhasil;
    }

    /**
     * Mengecek apakah data absensi sudah ada untuk kelas dan tanggal tertentu.
     */
    public function cekAbsensiSudahAda($id_kelas, $tanggal)
    {
        $query = "SELECT COUNT(id_absensi) as jumlah FROM absensi 
                  WHERE tanggal = :tanggal 
                  AND id_siswa IN (SELECT id_siswa FROM siswa WHERE id_kelas = :id_kelas)";
        
        $this->db->query($query);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('id_kelas', $id_kelas);
        $hasil = $this->db->single();
        return $hasil['jumlah'] > 0;
    }

    /**
     * Mengambil data laporan absensi (menampilkan SEMUA siswa di kelas).
     * Digunakan di halaman utama Absensi.
     */
    public function getAbsensiByKelasAndTanggal($id_kelas, $tanggal)
    {
        // Query diubah kembali untuk memulai dari tabel siswa
        $query = "SELECT s.id_siswa, s.nama_lengkap, s.nis, a.status, a.id_absensi
                  FROM siswa s
                  LEFT JOIN absensi a ON s.id_siswa = a.id_siswa AND a.tanggal = :tanggal
                  WHERE s.id_kelas = :id_kelas
                  ORDER BY s.nama_lengkap ASC";
        
        $this->db->query($query);
        $this->db->bind('id_kelas', $id_kelas);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }
    
    /**
     * Mengambil satu data absensi berdasarkan ID-nya (untuk modal edit).
     */
    public function getAbsenById($id_absensi)
    {
        $this->db->query("SELECT * FROM absensi WHERE id_absensi = :id_absensi");
        $this->db->bind('id_absensi', $id_absensi);
        return $this->db->single();
    }

    /**
     * Mengupdate satu data absensi.
     */
    public function updateAbsen($data)
    {
        $query = "UPDATE absensi SET status = :status WHERE id_absensi = :id_absensi";
        $this->db->query($query);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id_absensi', $data['id_absensi']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    /**
     * Menghapus satu data absensi.
     */
    public function hapusAbsen($id_absensi)
    {
        $query = "DELETE FROM absensi WHERE id_absensi = :id_absensi";
        $this->db->query($query);
        $this->db->bind('id_absensi', $id_absensi);
        $this->db->execute();
        return $this->db->rowCount();
    }

    /**
     * Menghapus semua data absensi berdasarkan id_kelas dan tanggal.
     */
    public function hapusAbsensiByKelasAndTanggal($id_kelas, $tanggal)
    {
        $query = "DELETE FROM absensi WHERE tanggal = :tanggal AND id_siswa IN (SELECT id_siswa FROM siswa WHERE id_kelas = :id_kelas)";
        $this->db->query($query);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('id_kelas', $id_kelas);
        $this->db->execute();
        return $this->db->rowCount();
    }

    /**
     * Mengambil data absensi untuk Laporan Detail per Kelas (Excel).
     */
    public function getLaporanAbsensiByKelas($id_kelas)
    {
        $query = "SELECT s.id_siswa, s.nama_lengkap, a.tanggal, a.status 
                  FROM absensi a
                  JOIN siswa s ON a.id_siswa = s.id_siswa
                  WHERE s.id_kelas = :id_kelas
                  ORDER BY s.nama_lengkap, a.tanggal";
        
        $this->db->query($query);
        $this->db->bind('id_kelas', $id_kelas);
        return $this->db->resultSet();
    }

    // ==========================================================
    // METHOD STATISTIK BARU UNTUK DASBOR HOME
    // ==========================================================

    public function getTanggalAbsenTerakhir()
    {
        $this->db->query("SELECT MAX(tanggal) as tanggal_terakhir FROM absensi");
        $result = $this->db->single();
        return $result['tanggal_terakhir'] ?? date('Y-m-d');
    }

    public function getStatistikPerTanggal($tanggal)
    {
        $query = "SELECT 
                    k.nama_kelas,
                    (SELECT COUNT(id_siswa) FROM siswa WHERE id_kelas = k.id_kelas) as total_siswa_kelas,
                    COALESCE(SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END), 0) as total_hadir
                  FROM kelas k
                  LEFT JOIN siswa s ON k.id_kelas = s.id_kelas
                  LEFT JOIN absensi a ON s.id_siswa = a.id_siswa AND a.tanggal = :tanggal
                  GROUP BY k.id_kelas, k.nama_kelas
                  ORDER BY k.nama_kelas";
        
        $this->db->query($query);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }
    
    public function getStatistikPerBulan($bulan, $tahun)
    {
        $query = "SELECT 
                    k.nama_kelas,
                    (SELECT COUNT(id_siswa) FROM siswa WHERE id_kelas = k.id_kelas) as total_siswa_kelas,
                    COALESCE(SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END), 0) as total_hadir
                  FROM kelas k
                  LEFT JOIN siswa s ON k.id_kelas = s.id_kelas
                  LEFT JOIN absensi a ON s.id_siswa = a.id_siswa AND MONTH(a.tanggal) = :bulan AND YEAR(a.tanggal) = :tahun
                  GROUP BY k.id_kelas, k.nama_kelas
                  ORDER BY k.nama_kelas";
        
        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function tambahSatuAbsen($data)
    {
        $query = "INSERT INTO absensi (id_siswa, tanggal, status) VALUES (:id_siswa, :tanggal, :status)";
        
        $this->db->query($query);
        $this->db->bind('id_siswa', $data['id_siswa']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }


}