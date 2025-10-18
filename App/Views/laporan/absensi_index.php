<div class="container mt-4">
    <h3>Laporan Absensi Siswa</h3>
    <p>Pilih kelas untuk melihat laporan absensi yang lebih detail.</p>
    <hr>

    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th scope="col" style="width: 10%;">No</th>
                <th scope="col">Nama Kelas</th>
                <th scope="col" style="width: 25%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['kelas'])) : ?>
                <tr>
                    <td colspan="3" class="text-center">Belum ada data kelas. Silakan tambahkan di menu Pengaturan.</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; ?>
                <?php foreach($data['kelas'] as $kelas) : ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= htmlspecialchars($kelas['nama_kelas']); ?></td>
                        <td>
                            <a href="<?= BASEURL; ?>/laporan/detailAbsensi/<?= $kelas['id_kelas']; ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-clipboard-data"></i> Lihat Laporan
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>