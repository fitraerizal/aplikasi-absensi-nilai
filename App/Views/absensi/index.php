<div class="container mt-4">
    <?php Flasher::flash(); ?>

    <div class="card mb-5 shadow-sm">
        <div class="card-header"><h5 class="mb-0">Mulai Sesi Absensi Baru</h5></div>
        <div class="card-body">
            <p class="card-text">Gunakan form ini untuk melakukan absensi massal pada tanggal tertentu.</p>
            <form action="<?= BASEURL; ?>/absensi/catat" method="post">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5"><label for="id_kelas" class="form-label">Pilih Kelas</label><select class="form-select" id="id_kelas" name="id_kelas" required><option value="" selected disabled>-- Pilih Kelas --</option><?php foreach($data['kelas'] as $kelas) : ?><option value="<?= $kelas['id_kelas']; ?>"><?= htmlspecialchars($kelas['nama_kelas']); ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-5"><label for="tanggal" class="form-label">Tanggal Absensi</label><input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>" required></div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-eye"></i> Tampilkan</button></div>
                </div>
            </form>
        </div>
    </div>
    
    <h3 class="mt-5">Laporan & Manajemen Absensi</h3>
    <div class="card shadow-sm">
        <div class="card-header"><h5 class="mb-0">Lihat Laporan Harian</h5></div>
        <div class="card-body">
            <p class="card-text">Gunakan filter ini untuk melihat, mengedit, atau menghapus data absensi yang sudah ada.</p>
            <form action="<?= BASEURL; ?>/absensi" method="post">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5"><label for="filter_kelas" class="form-label">Pilih Kelas</label><select class="form-select" id="filter_kelas" name="filter_kelas" required><option value="" disabled <?= is_null($data['filter_kelas']) ? 'selected' : ''; ?>>-- Pilih Kelas --</option><?php foreach($data['kelas'] as $kelas) : ?><option value="<?= $kelas['id_kelas']; ?>" <?= ($data['filter_kelas'] == $kelas['id_kelas']) ? 'selected' : ''; ?>><?= htmlspecialchars($kelas['nama_kelas']); ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-5"><label for="filter_tanggal" class="form-label">Pilih Tanggal Laporan</label><input type="date" class="form-control" id="filter_tanggal" name="filter_tanggal" value="<?= $data['filter_tanggal']; ?>" required></div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button></div>
                </div>
            </form>

            <table class="table table-striped table-bordered mt-4">
                <thead class="table-dark"><tr><th>Nama Siswa</th><th>NIS</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php if (is_null($data['filter_kelas'])) : ?>
                        <tr><td colspan="4" class="text-center">Silakan pilih kelas dan tanggal untuk menampilkan laporan.</td></tr>
                    <?php elseif (empty($data['laporan_absensi'])) : ?>
                        <tr><td colspan="4" class="text-center">Tidak ada data absensi yang ditemukan. Gunakan form di atas untuk memulai sesi absensi.</td></tr>
                    <?php else : ?>
                        <?php foreach($data['laporan_absensi'] as $absen) : ?>
                        <tr>
                            <td><?= htmlspecialchars($absen['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($absen['nis']); ?></td>
                            <td>
                                <?php $status = $absen['status'] ?? '-'; $badge_class = 'bg-light text-dark'; if ($status == 'Hadir') $badge_class = 'bg-success'; if ($status == 'Sakit') $badge_class = 'bg-warning text-dark'; if ($status == 'Izin') $badge_class = 'bg-info text-dark'; if ($status == 'Alfa') $badge_class = 'bg-danger'; ?><span class="badge <?= $badge_class; ?>"><?= $status; ?></span>
                            </td>
                            <td>
                                <?php if ($absen['status']) : ?>
                                    <a href="#" class="badge text-bg-success modalEditAbsen" data-id="<?= $absen['id_absensi']; ?>" data-bs-toggle="modal" data-bs-target="#editAbsenModal"><i class="bi bi-pencil-square"></i> Edit</a>
                                <?php else : ?>
                                    <a href="#" class="badge text-bg-primary modalEditAbsen" data-id_siswa="<?= $absen['id_siswa']; ?>" data-bs-toggle="modal" data-bs-target="#editAbsenModal"><i class="bi bi-plus-circle"></i> Absenkan</a>
                                <?php endif; ?>
                                <?php if ($absen['id_absensi']) : ?>
                                    <a href="<?= BASEURL; ?>/absensi/hapus/<?= $absen['id_absensi']; ?>" class="badge text-bg-danger" onclick="return confirm('Yakin?');"><i class="bi bi-trash"></i> Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (!empty($data['laporan_absensi'])) : ?>
            <div class="mt-3 text-end"><a href="<?= BASEURL; ?>/absensi/hapusMassal/<?= $data['filter_kelas']; ?>/<?= $data['filter_tanggal']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus semua data absensi untuk kelas dan tanggal ini?');"><i class="bi bi-trash"></i> Hapus Semua Absensi Hari Ini</a></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="editAbsenModal" tabindex="-1" aria-labelledby="editAbsenModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="editAbsenModalLabel">Ubah Status Kehadiran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/absensi/simpanSatu" method="post">
            <input type="hidden" name="id_absensi" id="id_absensi_edit">
            <input type="hidden" name="id_siswa" id="id_siswa_edit">
            <input type="hidden" name="tanggal" value="<?= $data['filter_tanggal']; ?>">
            <input type="hidden" name="id_kelas" value="<?= $data['filter_kelas']; ?>">
            
            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status" id="edit_hadir" value="Hadir"><label class="form-check-label" for="edit_hadir">Hadir</label></div>
            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status" id="edit_sakit" value="Sakit"><label class="form-check-label" for="edit_sakit">Sakit</label></div>
            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status" id="edit_izin" value="Izin"><label class="form-check-label" for="edit_izin">Izin</label></div>
            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status" id="edit_alfa" value="Alfa"><label class="form-check-label" for="edit_alfa">Alfa</label></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>