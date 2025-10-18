<div class="container mt-4">
    <h3>Pengelolaan Nilai Kelas: <?= htmlspecialchars($data['detail_kelas']['nama_kelas']); ?></h3>
    <hr>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5>Input Nilai Baru</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/nilai/tambah" method="post">
                        <input type="hidden" name="id_kelas" value="<?= $data['detail_kelas']['id_kelas']; ?>">
                        
                        <div class="mb-3">
                            <label for="id_siswa" class="form-label">Pilih Siswa</label>
                            <select class="form-select" id="id_siswa" name="id_siswa" required>
                                <option value="" selected disabled>-- Pilih Siswa --</option>
                                <?php foreach($data['siswa'] as $siswa) : ?>
                                    <option value="<?= $siswa['id_siswa']; ?>"><?= htmlspecialchars($siswa['nama_lengkap']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_penilaian" class="form-label">Jenis Penilaian</label>
                            <input type="text" class="form-control" id="jenis_penilaian" name="jenis_penilaian" placeholder="Contoh: Ulangan Harian, Tugas Praktik" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Contoh: Bab 1: Algoritma">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nilai" class="form-label">Nilai</label>
                                <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                                <input type="date" class="form-control" id="tanggal_penilaian" name="tanggal_penilaian" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <h5>Riwayat Nilai</h5>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Siswa</th>
                        <th>Penilaian</th>
                        <th>Nilai</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['nilai_kelas'])) : ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data nilai untuk kelas ini.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach($data['nilai_kelas'] as $nilai) : ?>
                            <tr>
                                <td><?= htmlspecialchars($nilai['nama_lengkap']); ?></td>
                                <td><?= htmlspecialchars($nilai['jenis_penilaian']); ?></td>
                                <td><?= htmlspecialchars($nilai['nilai']); ?></td>
                                <td><?= date('d M Y', strtotime($nilai['tanggal_penilaian'])); ?></td>
                                <td>
                                    <a href="#" class="badge bg-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>