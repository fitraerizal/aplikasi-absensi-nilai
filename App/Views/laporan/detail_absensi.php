<div class="container mt-4">
    <h3>Detail Laporan Absensi Kelas: <?= htmlspecialchars($data['kelas']['nama_kelas']); ?></h3>

    <div class="mb-3">
        <span class="badge bg-primary">Mata Pelajaran: <?= htmlspecialchars($data['mapel']['nama_mapel']); ?></span>
        <span class="badge bg-secondary">Tahun Ajaran: <?= htmlspecialchars($data['pengaturan']['tahun_ajaran']); ?></span>
        <span class="badge bg-success">Semester: <?= htmlspecialchars($data['pengaturan']['semester']); ?></span>
    </div>
    <hr>
    <div class="mb-3">
        <a href="<?= BASEURL; ?>/laporan/absensi" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
        <a href="<?= BASEURL; ?>/laporan/cetakAbsensi/<?= $data['kelas']['id_kelas']; ?>" class="btn btn-success">
            <i class="bi bi-printer"></i> Cetak Laporan (Excel)
        </a>
    </div>

    <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="align-middle" rowspan="2">Nama Siswa</th>
                        <?php foreach ($data['tanggal_unik'] as $tanggal) : ?>
                            <th><?= date('d M', strtotime($tanggal)); ?></th>
                        <?php endforeach; ?>
                        <th class="align-middle" colspan="4">Rekapitulasi</th>
                    </tr>
                    <tr>
                        <?php foreach ($data['tanggal_unik'] as $tanggal) : ?>
                            <th></th>
                        <?php endforeach; ?>
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>A</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['siswa'] as $siswa) : ?>
                        <tr>
                            <td class="text-start"><?= htmlspecialchars($siswa['nama_lengkap']); ?></td>
                            <?php foreach ($data['tanggal_unik'] as $tanggal) : ?>
                                <td>
                                    <?php
                                        $status = $data['laporan'][$siswa['id_siswa']][$tanggal] ?? '-';
                                        $badge_class = 'bg-light text-dark';
                                        if ($status == 'Hadir') $badge_class = 'bg-success';
                                        if ($status == 'Sakit') $badge_class = 'bg-warning text-dark';
                                        if ($status == 'Izin') $badge_class = 'bg-info text-dark';
                                        if ($status == 'Alfa') $badge_class = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_class; ?>"><?= $status; ?></span>
                                </td>
                            <?php endforeach; ?>
                            <td><strong><?= $data['rekap'][$siswa['id_siswa']]['hadir']; ?></strong></td>
                            <td><strong><?= $data['rekap'][$siswa['id_siswa']]['sakit']; ?></strong></td>
                            <td><strong><?= $data['rekap'][$siswa['id_siswa']]['izin']; ?></strong></td>
                            <td><strong><?= $data['rekap'][$siswa['id_siswa']]['alfa']; ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>