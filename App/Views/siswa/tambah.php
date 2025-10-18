<div class="container mt-4">
    <h3>Tambah Data Siswa</h3>
    <form action="<?= BASEURL; ?>/siswa/prosesTambah" method="post">
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
        </div>
        <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="number" class="form-control" id="nis" name="nis" required>
        </div>
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select class="form-select" id="id_kelas" name="id_kelas" required>
                <option value="1">VII A</option>
                <option value="2">VII B</option>
                <option value="3">VIII A</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Data</button>
    </form>
</div>