
    <div class="jumbotron-wavy-bg d-flex align-items-center justify-content-center text-center text-dark">
        <div class="jumbotron-content">
            <h1 class="display-4 fw-bold">Aplikasi Absensi & Pencatatan Nilai</h1>
                        
            <hr class="my-4">
            
            <h2 class="display-5"><?= htmlspecialchars(strtoupper($data['mapel']['nama_mapel'])); ?></h2>
            <h3 class="fw-normal mb-4"><?= htmlspecialchars($data['pengaturan']['nama_sekolah']); ?></h3>
            
            <p class="lead">
                Guru Pengampu: <strong><?= htmlspecialchars($data['pengaturan']['nama_guru_pengampu']); ?></strong>
            </p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-5">
                <a href="<?= BASEURL; ?>/absensi" class="btn btn-primary btn-lg px-4 gap-3">
                    <i class="bi bi-calendar-check"></i> Mulai Absensi
                </a>
                <a href="<?= BASEURL; ?>/nilai" class="btn btn-outline-warning btn-lg px-4">
                    <i class="bi bi-pencil-square"></i> Input Nilai
                </a>
            </div>
        </div>
    </div>


<div class="container my-5">
    <h2 class="text-center mb-4">Dasbor Statistik Kehadiran</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="<?= BASEURL; ?>/home" method="post">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="filter_tanggal" class="form-label">Tampilkan Statistik Pertemuan</label>
                        <input type="date" class="form-control" name="filter_tanggal" value="<?= $data['tanggal_aktif']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_bulan" class="form-label">Tampilkan Statistik Bulan</label>
                        <input type="month" class="form-control" name="filter_bulan" value="<?= $data['bulan_aktif']; ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Terapkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Persentase Kehadiran Pertemuan (<?= date('d M Y', strtotime($data['tanggal_aktif'])); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($data['statistik_harian'] as $stats) : ?>
                        <?php
                            // Perhitungan baru: (hadir / total siswa) * 100
                            $persentase = ($stats['total_siswa_kelas'] > 0) ? round(($stats['total_hadir'] / $stats['total_siswa_kelas']) * 100) : 0;
                        ?>
                        <strong><?= htmlspecialchars($stats['nama_kelas']); ?> (<?= $stats['total_hadir'] ?> dari <?= $stats['total_siswa_kelas'] ?> siswa hadir)</strong>
                        <div class="progress mb-3" role="progressbar" title="<?= $persentase; ?>%">
                            <div class="progress-bar bg-success" style="width: <?= $persentase; ?>%"><?= $persentase; ?>%</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Persentase Kehadiran Bulan (<?= date('F Y', strtotime($data['bulan_aktif'])); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($data['statistik_bulanan'] as $stats) : ?>
                         <?php
                            // Perhitungan baru: (hadir / total siswa) * 100
                            // Kita asumsikan total hadir di sini adalah akumulasi selama sebulan
                            $persentase = ($stats['total_siswa_kelas'] > 0) ? round(($stats['total_hadir'] / ($stats['total_siswa_kelas'] * 4)) * 100) : 0; // *Asumsi 4 pertemuan/bulan
                        ?>
                        <strong><?= htmlspecialchars($stats['nama_kelas']); ?></strong>
                        <div class="progress mb-3" role="progressbar" title="<?= $persentase; ?>%">
                            <div class="progress-bar" style="width: <?= $persentase; ?>%"><?= $persentase; ?>%</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>