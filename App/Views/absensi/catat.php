<div class="container mt-4">
    <h3>Form Absensi Tanggal: <?= date('d F Y', strtotime($data['tanggal'])); ?></h3>
    <hr>
    
    <form action="<?= BASEURL; ?>/absensi/simpan" method="post">
        <input type="hidden" name="tanggal" value="<?= $data['tanggal']; ?>">
        <input type="hidden" name="id_kelas" value="<?= $data['id_kelas']; ?>">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th class="text-center" width="40%">Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['siswa'] as $siswa) : ?>
                    <tr>
                        <td><?= htmlspecialchars($siswa['nama_lengkap']); ?></td>
                        <td>
                            <input type="hidden" name="id_siswa[]" value="<?= $siswa['id_siswa']; ?>">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[<?= $siswa['id_siswa']; ?>]" id="hadir_<?= $siswa['id_siswa']; ?>" value="Hadir" checked>
                                <label class="form-check-label" for="hadir_<?= $siswa['id_siswa']; ?>">Hadir</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[<?= $siswa['id_siswa']; ?>]" id="sakit_<?= $siswa['id_siswa']; ?>" value="Sakit">
                                <label class="form-check-label" for="sakit_<?= $siswa['id_siswa']; ?>">Sakit</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[<?= $siswa['id_siswa']; ?>]" id="izin_<?= $siswa['id_siswa']; ?>" value="Izin">
                                <label class="form-check-label" for="izin_<?= $siswa['id_siswa']; ?>">Izin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[<?= $siswa['id_siswa']; ?>]" id="alfa_<?= $siswa['id_siswa']; ?>" value="Alfa">
                                <label class="form-check-label" for="alfa_<?= $siswa['id_siswa']; ?>">Alfa</label>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan Absensi
        </button>
    </form>
</div>