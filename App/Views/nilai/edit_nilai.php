<div class="container mt-4">
    <h4>Edit Nilai untuk: <?= htmlspecialchars($data['tugas']['nama_tugas']); ?></h4>
    <h5>Kelas: <?= htmlspecialchars($data['kelas']['nama_kelas']); ?></h5>
    <hr>
    <form action="<?= BASEURL; ?>/nilai/updateMassal" method="post">
        <input type="hidden" name="id_tugas" value="<?= $data['tugas']['id_tugas']; ?>">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama Siswa</th>
                    <th width="20%">Nilai (0-100)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['siswa'] as $siswa) : ?>
                <tr>
                    <td><?= htmlspecialchars($siswa['nama_lengkap']); ?></td>
                    <td>
                        <?php
                            // Cek apakah siswa ini sudah punya nilai, jika ya, tampilkan
                            $nilai_sebelumnya = $data['nilai_siswa'][$siswa['id_siswa']] ?? '';
                        ?>
                        <input type="number" name="nilai[<?= $siswa['id_siswa']; ?>]" class="form-control" value="<?= $nilai_sebelumnya; ?>" min="0" max="100">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= BASEURL; ?>/nilai" class="btn btn-secondary">Kembali</a>
    </form>
</div>