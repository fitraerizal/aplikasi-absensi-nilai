<div class="container mt-4">
    <h3>Pilih Tugas untuk Input Nilai</h3>
    <p>Pilih kelas terlebih dahulu untuk melihat daftar tugas yang tersedia.</p>
    <div class="card mt-4">
        <div class="card-body">
            <form action="<?= BASEURL; ?>/nilai/inputMassal" method="post">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="id_kelas" class="form-label">Kelas</label>
                        <select class="form-select" name="id_kelas" id="id_kelas_for_tugas" required>
                            <option value="" selected disabled>-- Pilih Kelas --</option>
                            <?php foreach($data['kelas'] as $kelas) : ?>
                            <option value="<?= $kelas['id_kelas']; ?>"><?= htmlspecialchars($kelas['nama_kelas']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                         <label for="id_tugas" class="form-label">Tugas</label>
                        <select class="form-select" name="id_tugas" id="id_tugas_select" required>
                            <option value="" selected disabled>-- Pilih kelas dulu --</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Lanjutkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>