<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Pengelolaan Nilai Siswa 📊</h3>
        <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahTugasModal">
                <i class="bi bi-plus-circle"></i> Buat Tugas Baru
            </button>
            
        </div>
    </div>
    <hr>
    <?php Flasher::flash(); ?>

    <h5>Daftar Tugas yang Sudah Dibuat</h5>

    <div class="card my-3">
        <div class="card-body">
            <form action="<?= BASEURL; ?>/nilai/index" method="post">
                <div class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label for="id_kelas" class="form-label">Filter Berdasarkan Kelas</label>
                        <select class="form-select" name="id_kelas">
                            <option value="">-- Tampilkan Semua Kelas --</option>
                            <?php foreach($data['kelas'] as $kelas) : ?>
                                <option value="<?= $kelas['id_kelas']; ?>" <?= ($data['id_kelas_aktif'] == $kelas['id_kelas']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($kelas['nama_kelas']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Nama Tugas</th>
                <th>Kelas</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['tugas'])) : ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada tugas yang cocok dengan filter.</td>
                </tr>
            <?php else : ?>
                <?php foreach($data['tugas'] as $tugas) : ?>
                <tr>
                    <td><?= date('d M Y', strtotime($tugas['tanggal_tugas'])); ?></td>
                    <td><?= htmlspecialchars($tugas['nama_tugas']); ?></td>
                    <td><?= htmlspecialchars($tugas['nama_kelas']); ?></td>
                    <td><?= htmlspecialchars($tugas['deskripsi']); ?></td>
                    <td>
                    <a href="<?= BASEURL; ?>/nilai/lihat/<?= $tugas['id_tugas']; ?>" class="btn btn-info btn-sm" title="Lihat Detail Nilai">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        
                        <a href="<?= BASEURL; ?>/nilai/editNilai/<?= $tugas['id_tugas']; ?>" class="btn btn-success btn-sm" title="Edit Nilai yang Sudah Ada">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="<?= BASEURL; ?>/nilai/hapusTugas/<?= $tugas['id_tugas']; ?>" class="btn btn-danger btn-sm" title="Hapus Tugas" onclick="return confirm('Yakin ingin menghapus tugas ini? Semua nilai yang terkait akan ikut terhapus!');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="tambahTugasModal" tabindex="-1" aria-labelledby="tambahTugasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahTugasModalLabel">Buat Tugas / Penilaian Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/nilai/tambahTugas" method="post">
            <div class="mb-3">
                <label for="id_kelas" class="form-label">Untuk Kelas</label>
                <select class="form-select" name="id_kelas" required>
                    <option value="" selected disabled>-- Pilih Kelas --</option>
                    <?php foreach($data['kelas'] as $kelas) : ?>
                    <option value="<?= $kelas['id_kelas']; ?>"><?= htmlspecialchars($kelas['nama_kelas']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nama_tugas" class="form-label">Nama Tugas/Penilaian</label>
                <input type="text" class="form-control" name="nama_tugas" placeholder="Contoh: Ulangan Harian Bab 1" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                <input type="text" class="form-control" name="deskripsi">
            </div>
            <div class="mb-3">
                <label for="tanggal_tugas" class="form-label">Tanggal Tugas</label>
                <input type="date" class="form-control" name="tanggal_tugas" value="<?= date('Y-m-d'); ?>" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Tugas</button>
        </form>
      </div>
    </div>
  </div>
</div>