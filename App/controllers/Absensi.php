<?php

class Absensi extends Controller {

    public function __construct() {
        parent::__construct(); 
    }

    public function index()
    {
        $data['judul'] = 'Pencatatan & Laporan Absensi';
        $data['kelas'] = $this->model('Kelas_model')->getAllKelas();
        
        $data['filter_tanggal'] = $_POST['filter_tanggal'] ?? date('Y-m-d');
        $data['filter_kelas'] = $_POST['filter_kelas'] ?? null;
        
        $data['laporan_absensi'] = [];
        if ($data['filter_kelas']) {
            $data['laporan_absensi'] = $this->model('Absensi_model')->getAbsensiByKelasAndTanggal($data['filter_kelas'], $data['filter_tanggal']);
        }

        $this->view('templates/header', $data);
        $this->view('absensi/index', $data);
        $this->view('templates/footer');
    }

    public function catat()
    {
        $id_kelas = $_POST['id_kelas'];
        $tanggal = $_POST['tanggal'];

        if ($this->model('Absensi_model')->cekAbsensiSudahAda($id_kelas, $tanggal)) {
            $pesan = "Gagal! Anda sudah melakukan absensi pada tanggal " . date('d F Y', strtotime($tanggal)) . ". Gunakan fitur edit di laporan jika ingin mengubah.";
            Flasher::setFlash($pesan, 'warning');
            header('Location: ' . BASEURL . '/absensi');
            exit;
        }

        $data['judul'] = 'Catat Kehadiran';
        $data['siswa'] = $this->model('Siswa_model')->getSiswaByIdKelas($id_kelas);
        $data['tanggal'] = $tanggal;
        $data['id_kelas'] = $id_kelas;
        
        $this->view('templates/header', $data);
        $this->view('absensi/catat', $data);
        $this->view('templates/footer');
    }

    public function simpan()
    {
        if ($this->model('Absensi_model')->simpanAbsensi($_POST) > 0) {
            Flasher::setFlash('Data absensi berhasil disimpan.', 'success');
        } else {
            Flasher::setFlash('Gagal menyimpan data absensi.', 'danger');
        }
        header('Location: ' . BASEURL . '/home');
        exit;
    }

    public function getDetail() // Untuk AJAX
    {
        echo json_encode($this->model('Absensi_model')->getAbsenById($_POST['id']));
    }

    public function simpanSatu()
    {
        // Cek apakah ini mode edit (ada id_absensi) atau mode tambah baru
        if (isset($_POST['id_absensi']) && !empty($_POST['id_absensi'])) {
            // JALANKAN LOGIKA UPDATE
            if ($this->model('Absensi_model')->updateAbsen($_POST) > 0) {
                Flasher::setFlash('Status kehadiran berhasil diubah.', 'success');
            } else {
                Flasher::setFlash('Tidak ada perubahan disimpan.', 'info');
            }
        } else {
            // JALANKAN LOGIKA INSERT BARU
            if ($this->model('Absensi_model')->tambahSatuAbsen($_POST) > 0) {
                Flasher::setFlash('Siswa berhasil diabsen.', 'success');
            } else {
                Flasher::setFlash('Gagal mengabsen siswa.', 'danger');
            }
        }
        
        // ==========================================================
        // PERBAIKAN KUNCI ADA DI SINI: REDIRECT DENGAN FILTER
        // Kita akan melakukan "fake POST" dengan mengalihkan ke halaman absensi
        // sambil mengirimkan parameter filter.
        // ==========================================================
        
        // Buat form tersembunyi yang akan otomatis di-submit oleh JavaScript
        echo '
            <form id="redirectForm" action="' . BASEURL . '/absensi" method="post">
                <input type="hidden" name="filter_kelas" value="' . $_POST['id_kelas'] . '">
                <input type="hidden" name="filter_tanggal" value="' . $_POST['tanggal'] . '">
            </form>
            <script type="text/javascript">
                document.getElementById("redirectForm").submit();
            </script>
        ';
        exit;
    }

    public function hapus($id_absensi)
    {
        if ($this->model('Absensi_model')->hapusAbsen($id_absensi) > 0) {
            Flasher::setFlash('Data absensi siswa berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Gagal menghapus data absensi.', 'danger');
        }
        header('Location: ' . BASEURL . '/absensi');
        exit;
    }

    public function hapusMassal($id_kelas, $tanggal)
    {
        if ($this->model('Absensi_model')->hapusAbsensiByKelasAndTanggal($id_kelas, $tanggal) > 0) {
            Flasher::setFlash('Semua data absensi untuk tanggal tersebut berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Gagal menghapus data absensi.', 'danger');
        }
        header('Location: ' . BASEURL . '/absensi');
        exit;
    }
}