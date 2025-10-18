<div class="container mt-4">
    <h3>Detail Laporan Nilai Kelas: <?= htmlspecialchars($data['kelas']['nama_kelas']); ?></h3>
    <div class="mb-3">
        <span class="badge bg-secondary">Tahun Ajaran: <?= htmlspecialchars($data['pengaturan']['tahun_ajaran']); ?></span>
        <span class="badge bg-success">Semester: <?= htmlspecialchars($data['pengaturan']['semester']); ?></span>
    </div>
    <hr>
    
    <div class="mb-3">
        <a href="<?= BASEURL; ?>/laporan/nilai" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
        <a href="<?= BASEURL; ?>/laporan/cetakNilai/<?= $data['kelas']['id_kelas']; ?>" class="btn btn-success">
            <i class="bi bi-printer"></i> Cetak Laporan (Excel)
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th class="align-middle">Nama Siswa</th>
                    <?php foreach ($data['tugas'] as $tugas) : ?>
                        <th class="align-middle"><?= htmlspecialchars($tugas['nama_tugas']); ?></th>
                    <?php endforeach; ?>
                    <th class="align-middle">Rata-Rata</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['siswa'] as $siswa) : ?>
                    <tr>
                        <td class="text-start"><?= htmlspecialchars($siswa['nama_lengkap']); ?></td>
                        <?php foreach ($data['tugas'] as $tugas) : ?>
                            <td>
                                <?= $data['laporan_nilai'][$siswa['id_siswa']][$tugas['id_tugas']] ?? '-'; ?>
                            </td>
                        <?php endforeach; ?>
                        <td><strong><?= $data['rata_rata'][$siswa['id_siswa']]; ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
       </table>
    </div>
</div>