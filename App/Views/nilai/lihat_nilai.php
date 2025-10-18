<div class="container mt-4">
    <h4>Daftar Nilai untuk: <?= htmlspecialchars($data['tugas']['nama_tugas']); ?></h4>
    <h5>Kelas: <?= htmlspecialchars($data['kelas']['nama_kelas']); ?> | Tanggal: <?= date('d M Y', strtotime($data['tugas']['tanggal_tugas'])); ?></h5>
    <hr>

    <a href="<?= BASEURL; ?>/nilai" class="btn btn-secondary mb-3">Kembali ke Dasbor Nilai</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['daftar_nilai'])) : ?>
                <tr>
                    <td colspan="4" class="text-center">Belum ada nilai yang diinput untuk tugas ini.</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; ?>
                <?php foreach ($data['daftar_nilai'] as $nilai) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($nilai['nama_lengkap']); ?></td>
                        <td><?= htmlspecialchars($nilai['nis']); ?></td>
                        <td><strong><?= htmlspecialchars($nilai['nilai']); ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>