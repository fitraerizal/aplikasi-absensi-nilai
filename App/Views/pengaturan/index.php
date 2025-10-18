<div class="container mt-4">
    <h3>Pengaturan Aplikasi</h3>
    <hr>

    <div class="row">
        <div class="col-lg-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Pengaturan Umum</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/pengaturan/update" method="post">
                        <div class="mb-3">
                            <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="<?= htmlspecialchars($data['pengaturan']['nama_sekolah']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_guru_pengampu" class="form-label">Nama Guru Pengampu</label>
                            <input type="text" class="form-control" id="nama_guru_pengampu" name="nama_guru_pengampu" value="<?= htmlspecialchars($data['pengaturan']['nama_guru_pengampu']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="<?= htmlspecialchars($data['pengaturan']['tahun_ajaran']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-select" id="semester" name="semester">
                                <option value="Ganjil" <?= ($data['pengaturan']['semester'] == 'Ganjil') ? 'selected' : ''; ?>>Ganjil</option>
                                <option value="Genap" <?= ($data['pengaturan']['semester'] == 'Genap') ? 'selected' : ''; ?>>Genap</option>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Ubah Nama Mata Pelajaran</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/pengaturan/updateMapel" method="post">
                        <input type="hidden" name="id_mapel" value="<?= $data['mapel']['id_mapel']; ?>">
                        <div class="mb-3">
                            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="<?= htmlspecialchars($data['mapel']['nama_mapel']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Tambah Kelas Baru</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/pengaturan/tambahKelas" method="post">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="Contoh: VII A" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah
                        </button>
                    </form>
                </div>
            </div>

            <h5>Daftar Kelas Saat Ini</h5>
            <ul class="list-group">
                <?php foreach($data['kelas'] as $kelas) : ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($kelas['nama_kelas']); ?>
                        <a href="<?= BASEURL; ?>/pengaturan/hapusKelas/<?= $kelas['id_kelas']; ?>" class="badge bg-danger float-end ms-1" onclick="return confirm('Yakin ingin menghapus?');" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="<?= BASEURL; ?>/pengaturan/editKelas/<?= $kelas['id_kelas']; ?>" class="badge bg-success float-end ms-1" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>