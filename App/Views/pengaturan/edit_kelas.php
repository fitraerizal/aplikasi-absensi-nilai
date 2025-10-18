<div class="container mt-4">
    <h3>Edit Nama Kelas</h3>
    <hr>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/pengaturan/updateKelas" method="post">
                        <input type="hidden" name="id_kelas" value="<?= $data['kelas']['id_kelas']; ?>">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?= htmlspecialchars($data['kelas']['nama_kelas']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= BASEURL; ?>/pengaturan" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>