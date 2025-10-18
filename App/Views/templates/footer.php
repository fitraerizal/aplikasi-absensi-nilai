<footer class="footer mt-auto py-3 bg-dark fixed-bottom">
    <div class="container text-center">
        <span class="text-white" style="font-size: 10px;">Created By 
            <a href="https://web.facebook.com/phytra.elamanteeryzal" target="_blank" class="text-white fw-bold text-decoration-none">@LFErizal</a>
        </span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
 <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(function() {
            // Ketika tombol 'Tambah Data Siswa' di-klik
            $('.btn-primary[data-bs-target="#formModal"]').on('click', function() {
                $('#judulModal').html('Tambah Data Siswa');
                $('.modal-footer button[type=submit]').html('Simpan Data');
                $('#nama_lengkap').val('');
                $('#nis').val('');
                $('#id_kelas').val('');
                // Arahkan action form ke method 'tambah'
                $('.modal-body form').attr('action', '<?= BASEURL; ?>/siswa/tambah');
            });

            // Ketika tombol 'Edit' di-klik
            $('.tampilModalUbah').on('click', function() {
                $('#judulModal').html('Ubah Data Siswa');
                $('.modal-footer button[type=submit]').html('Simpan Perubahan');
                // Arahkan action form ke method 'ubah'
                $('.modal-body form').attr('action', '<?= BASEURL; ?>/siswa/ubah');
                
                const id = $(this).data('id');
                
                // Jalankan AJAX untuk mengambil data
                $.ajax({
                    url: '<?= BASEURL; ?>/siswa/getubah',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        $('#nama_lengkap').val(data.nama_lengkap);
                        $('#nis').val(data.nis);
                        $('#id_kelas').val(data.id_kelas);
                        $('.modal-body form').append('<input type="hidden" name="id_siswa" value="' + data.id_siswa + '">');
                    }
                });
            });
        });
    </script>


    <script>
        // Letakkan di dalam $(function() { ... });
        // Letakkan di dalam $(function() { ... });
        $('#id_kelas_for_tugas').on('change', function() {
            const id_kelas = $(this).val();
            const tugasSelect = $('#id_tugas_select');

            tugasSelect.html('<option>Memuat...</option>');

            $.ajax({
                url: '<?= BASEURL; ?>/nilai/getTugasByKelas',
                data: {id_kelas : id_kelas},
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    tugasSelect.empty();
                    tugasSelect.append('<option value="" selected disabled>-- Pilih Tugas --</option>');
                    
                    $.each(data, function(key, value) {
                        tugasSelect.append('<option value="' + value.id_tugas + '">' + value.nama_tugas + '</option>');
                    });
                }
            });
        });

    </script>

    <script>
        $(function() {

            // ==========================================================
            // ## UNTUK MODAL EDIT SISWA (di halaman Siswa) ##
            // ==========================================================
            // Mengatur ulang modal saat tombol 'Tambah Data' di-klik
            $('.btn-success[data-bs-target="#formModal"]').on('click', function() {
                $('#judulModal').html('Tambah Data Siswa');
                $('.modal-footer button[type=submit]').html('Simpan Data');
                $('#nama_lengkap').val('');
                $('#nis').val('');
                $('#id_kelas').val('');
                $('#id_siswa').remove(); // Hapus input hidden id_siswa jika ada
                $('.modal-body form').attr('action', '<?= BASEURL; ?>/siswa/tambah');
            });

            // Menampilkan data ke modal saat tombol 'Edit' di-klik
            $('.tampilModalUbah').on('click', function() {
                $('#judulModal').html('Ubah Data Siswa');
                $('.modal-footer button[type=submit]').html('Simpan Perubahan');
                $('.modal-body form').attr('action', '<?= BASEURL; ?>/siswa/ubah');
                
                const id = $(this).data('id');
                
                $.ajax({
                    url: '<?= BASEURL; ?>/siswa/getubah',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        $('#nama_lengkap').val(data.nama_lengkap);
                        $('#nis').val(data.nis);
                        $('#id_kelas').val(data.id_kelas);
                        // Hapus dulu input id_siswa yang mungkin ada dari edit sebelumnya
                        $('#id_siswa').remove(); 
                        // Tambahkan input hidden baru dengan id_siswa yang benar
                        $('.modal-body form').append('<input type="hidden" id="id_siswa" name="id_siswa" value="' + data.id_siswa + '">');
                    }
                });
            });

            // ==========================================================
            // ## UNTUK DROPDOWN TUGAS (di halaman Pilih Tugas) ##
            // ==========================================================
            $('#id_kelas_for_tugas').on('change', function() {
                const id_kelas = $(this).val();
                const tugasSelect = $('#id_tugas_select');

                tugasSelect.html('<option>Memuat...</option>');

                $.ajax({
                    url: '<?= BASEURL; ?>/nilai/getTugasByKelas',
                    data: {id_kelas : id_kelas},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        tugasSelect.empty();
                        tugasSelect.append('<option value="" selected disabled>-- Pilih Tugas --</option>');
                        
                        $.each(data, function(key, value) {
                            tugasSelect.append('<option value="' + value.id_tugas + '">' + value.nama_tugas + '</option>');
                        });
                    }
                });
            });

            // ==========================================================
            // ## UNTUK MODAL EDIT ABSENSI (di halaman Absensi) ##
            // ==========================================================
            // ## UNTUK MODAL EDIT/TAMBAH ABSENSI (di halaman Absensi) ##
            $('.modalEditAbsen').on('click', function() {
            // Selalu reset form setiap kali modal dibuka
                $('#editAbsenModal form')[0].reset();
                $('#id_absensi_edit').val('');
                $('#id_siswa_edit').val('');

                const id_absensi = $(this).data('id');
                const id_siswa = $(this).data('id_siswa');

                // Jika ada 'data-id', berarti ini mode EDIT
                if (id_absensi) {
                    $.ajax({
                        url: '<?= BASEURL; ?>/absensi/getDetail',
                        data: {id : id_absensi},
                        method: 'post',
                        dataType: 'json',
                        success: function(data) {
                            $('#id_absensi_edit').val(data.id_absensi);
                            $('#id_siswa_edit').val(data.id_siswa);
                            // Pilih radio button yang sesuai
                            $('input[name=status][value="' + data.status + '"]').prop('checked', true);
                        }
                    });
                } 
                // Jika tidak ada 'data-id', berarti ini mode TAMBAH BARU (Absenkan)
                else { 
                    $('#id_siswa_edit').val(id_siswa);
                    // Set pilihan default ke 'Hadir'
                    $('input[name=status][value="Hadir"]').prop('checked', true);
                }
            });

        });
    </script>

</body>
</html>
</body>
</html>