<div class="container mt-4">
    <h3>Laporan Nilai Siswa</h3>
    <p>Pilih kelas untuk melihat rekapitulasi nilai akhir siswa.</p>
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
            <?php $no = 1; ?>
            <?php foreach($data['kelas'] as $kelas) : ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= htmlspecialchars($kelas['nama_kelas']); ?></td>
                    <td>
                        <a href="<?= BASEURL; ?>/laporan/detailNilai/<?= $kelas['id_kelas']; ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-clipboard-data"></i> Lihat Laporan Nilai
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>