-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Okt 2025 pada 01.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_informatika`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alfa') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_siswa`, `tanggal`, `status`, `keterangan`) VALUES
(24, 1, '2025-10-08', 'Hadir', NULL),
(25, 2, '2025-10-08', 'Sakit', NULL),
(27, 12, '2025-10-16', 'Hadir', NULL),
(29, 12, '2025-10-15', 'Hadir', NULL),
(31, 12, '2025-10-09', 'Hadir', NULL),
(33, 12, '2025-10-02', 'Alfa', NULL),
(35, 12, '2025-09-30', 'Hadir', NULL),
(37, 12, '2025-09-10', 'Sakit', NULL),
(39, 12, '2025-08-06', 'Izin', NULL),
(40, 9, '2025-10-16', 'Hadir', NULL),
(41, 10, '2025-10-16', 'Hadir', NULL),
(42, 11, '2025-10-16', 'Hadir', NULL),
(43, 9, '2025-10-02', 'Hadir', NULL),
(44, 10, '2025-10-02', 'Alfa', NULL),
(45, 11, '2025-10-02', 'Hadir', NULL),
(50, 9, '2025-10-17', 'Hadir', NULL),
(51, 19, '2025-10-17', 'Alfa', NULL),
(52, 10, '2025-10-17', 'Izin', NULL),
(53, 13, '2025-10-17', 'Hadir', NULL),
(54, 14, '2025-10-17', 'Alfa', NULL),
(55, 15, '2025-10-17', 'Hadir', NULL),
(56, 1, '2025-10-17', 'Hadir', NULL),
(57, 2, '2025-10-17', 'Hadir', NULL),
(58, 17, '2025-10-17', 'Alfa', NULL),
(59, 18, '2025-10-17', 'Hadir', NULL),
(60, 16, '2025-10-17', 'Hadir', NULL),
(61, 17, '2025-10-03', 'Hadir', NULL),
(62, 18, '2025-10-03', 'Sakit', NULL),
(63, 16, '2025-10-03', 'Izin', NULL),
(64, 17, '2025-10-14', 'Hadir', NULL),
(65, 18, '2025-10-14', 'Hadir', NULL),
(66, 16, '2025-10-14', 'Sakit', NULL),
(68, 8, '2025-10-13', 'Hadir', NULL),
(69, 11, '2025-10-13', 'Hadir', NULL),
(70, 20, '2025-10-13', 'Hadir', NULL),
(71, 12, '2025-10-13', 'Sakit', NULL),
(72, 8, '2025-10-17', 'Hadir', NULL),
(73, 11, '2025-10-17', 'Hadir', NULL),
(74, 20, '2025-10-17', 'Hadir', NULL),
(77, 12, '2025-10-17', 'Hadir', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL COMMENT 'Contoh: VII A, VIII B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'VII-1'),
(2, 'VII-2'),
(4, 'IX-1'),
(5, 'IX-2'),
(6, 'IX-3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id_mapel`, `nama_mapel`) VALUES
(1, 'KODING DAN KECERDASAN ARTIFISIAL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `nilai` int(3) NOT NULL,
  `tanggal_penilaian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_siswa`, `id_tugas`, `nilai`, `tanggal_penilaian`) VALUES
(2, 12, 1, 70, '2025-10-16'),
(3, 9, 2, 75, '2025-10-16'),
(4, 10, 2, 80, '2025-10-16'),
(5, 11, 2, 87, '2025-10-16'),
(16, 1, 5, 80, '2025-10-16'),
(17, 2, 5, 90, '2025-10-16'),
(18, 8, 5, 80, '2025-10-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`setting_key`, `setting_value`) VALUES
('nama_guru_pengampu', 'La Ode Fitra Erizal'),
('nama_sekolah', 'SMPN 1 WANGI-WANGI SELATAN'),
('semester', 'Ganjil'),
('tahun_ajaran', '2025/2026');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama_lengkap`, `id_kelas`) VALUES
(1, '2324001', 'Ahmad ZulkifliI', 1),
(2, '2324002', 'Bunga Citra Lestari', 1),
(8, '93838', 'Joko', 4),
(9, '9373', 'Arman', 5),
(10, '93883', 'Jamal', 5),
(11, '93839', 'Kirana', 4),
(12, '837387', 'Suparman', 4),
(13, '878788', 'Axel', 6),
(14, '888882', 'Indri', 6),
(15, '72727', 'Januar', 6),
(16, '289829', 'Sarah', 2),
(17, '88889', 'Citra', 2),
(18, '878987', 'Kodir', 2),
(19, '88279', 'Jaelani', 5),
(20, '83880', 'Sumarto', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nama_tugas` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `tanggal_tugas` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `id_kelas`, `nama_tugas`, `deskripsi`, `tanggal_tugas`) VALUES
(1, 4, 'Praktikum Python', '', '2025-10-16'),
(2, 5, 'Praktikum Python', '', '2025-10-16'),
(3, 4, 'Identifikasi masalah', '', '2025-10-07'),
(5, 1, 'Membuat Presentasi di Canva', '', '2025-10-16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD UNIQUE KEY `siswa_unik_per_tugas` (`id_siswa`,`id_tugas`),
  ADD KEY `id_tugas` (`id_tugas`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
