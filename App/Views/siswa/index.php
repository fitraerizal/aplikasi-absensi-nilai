<div class="container mt-4">
    <h3>Daftar Siswa</h3>
    <hr>

    

    <div class="row">
        <div class="col-lg-4 text-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="bi bi-plus-circle"></i> Tambah Data Siswa
            </button>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-file-earmark-arrow-up"></i> Import from Excel
            </button>
        </div>
    </div><hr>
    
    <div class="row">
        
        <div class="col-lg-4">
            <form action="<?= BASEURL; ?>/siswa/index" method="post">
                <div class="input-group mb-3">
                    
                    <input type="text" class="form-control" placeholder="Cari nama siswa..." name="keyword" value="<?= htmlspecialchars($data['keyword_aktif'] ?? ''); ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
           
        <div class="col-lg-4">
            <form action="<?= BASEURL; ?>/siswa/index" method="post">
                <div class="input-group mb-3">
                    <select class="form-select" name="id_kelas">
                        <option value="">-- Tampilkan Semua Kelas --</option>
                        <?php foreach($data['kelas'] as $kelas) : ?>
                            <option value="<?= $kelas['id_kelas']; ?>" <?= ($data['id_kelas_aktif'] == $kelas['id_kelas']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($kelas['nama_kelas']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-striped table-bordered mt-2">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['siswa'])) : ?>
                <tr>
                    <td colspan="5" class="text-center">Data siswa tidak ditemukan.</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; ?>
                <?php foreach ($data['siswa'] as $siswa) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($siswa['nama_lengkap']); ?></td>
                        <td><?= htmlspecialchars($siswa['nis']); ?></td>
                        <td><?= htmlspecialchars($siswa['nama_kelas']); ?></td>
                        <td>
                            <a href="<?= BASEURL; ?>/siswa/hapus/<?= $siswa['id_siswa']; ?>" class="badge bg-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                            <a href="#" class="badge bg-success tampilModalUbah" data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $siswa['id_siswa']; ?>">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div> <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="judulModal">Tambah Data Siswa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/siswa/tambah" method="post">
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" required>
            </div>
            <div class="mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select class="form-select" id="id_kelas" name="id_kelas" required>
                    <option value="" selected disabled>-- Pilih Kelas --</option>
                    <?php foreach($data['kelas'] as $kelas) : ?>
                        <option value="<?= $kelas['id_kelas']; ?>"><?= htmlspecialchars($kelas['nama_kelas']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-lg"></i> Tutup
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan Data
        </button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="uploadModalLabel">Import Data Siswa dari Excel</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Panduan:</strong></p>
        <ul>
            <li>File harus berformat `.xlsx` atau `.xls`.</li>
            <li>Kolom A harus berisi **Nama Lengkap**.</li>
            <li>Kolom B harus berisi **NIS**.</li>
        </ul>
        <form action="<?= BASEURL; ?>/siswa/upload" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="id_kelas_import" class="form-label">Impor ke Kelas:</label>
                <select class="form-select" id="id_kelas_import" name="id_kelas" required>
                    <option value="" selected disabled>-- Pilih Kelas Tujuan --</option>
                    <?php foreach($data['kelas'] as $kelas) : ?>
                        <option value="<?= $kelas['id_kelas']; ?>"><?= htmlspecialchars($kelas['nama_kelas']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fileExcel" class="form-label">Pilih File Excel</label>
                <input class="form-control" type="file" id="fileExcel" name="fileExcel" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-lg"></i> Tutup
        </button>        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-upload"></i> Upload dan Simpan
        </button>
        </form>
      </div>
    </div>
  </div>
</div>