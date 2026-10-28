-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Okt 2026 pada 11.53
-- Versi server: 8.0.30
-- Versi PHP: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `pkl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_kelas`
--

CREATE TABLE `detail_kelas` (
  `id` int NOT NULL,
  `id_klsmk` int NOT NULL,
  `nim` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `detail_kelas`
--

INSERT INTO `detail_kelas` (`id`, `id_klsmk`, `nim`) VALUES
(25, 21, '240302062'),
(26, 21, '24088596'),
(27, 22, '240302062'),
(28, 22, '24088596'),
(29, 17, '240302062'),
(33, 27, '010101');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `nik` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kelamin` char(1) NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`nik`, `nama`, `kontak`, `email`, `kelamin`, `img`) VALUES
('085120451', 'Bu rostika', '0852051', 'okjin@gmail.com', 'p', NULL),
('09562520', 'Pak Dimas', '8521', 'goviii507@gmail.com', 'l', '../asset_web/img/foto_dosen1790935350.png'),
('2685241', 'Pak Ambau', '0852541201145', 'plkojnji@gmail.com', 'l', NULL),
('5421521', 'Pak Fajar', '020202', 'goviii507@gmail.com', 'l', '../asset_web/img/foto_dosen1790935295.png'),
('745120', 'Bu Laura', '01010101', 'goviii507@gmail.com', 'p', '../asset_web/img/foto_dosen1790935305.png'),
('852542542', 'Bu Novi', '85425', 'goviii507@gmail.com', 'p', '../asset_web/img/foto_dosen1790935316.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `kode_jurusan` varchar(10) NOT NULL,
  `nama_jurusan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`kode_jurusan`, `nama_jurusan`) VALUES
('01', 'Mesin V'),
('02', 'JREM'),
('03', 'JKB'),
('77', 'Elektronika'),
('88', 'Sastra Inggris'),
('99', 'Astronomi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_makul`
--

CREATE TABLE `kelas_makul` (
  `id` int NOT NULL,
  `kode_akd` varchar(10) NOT NULL,
  `kode_makul` varchar(10) NOT NULL,
  `kode_jurusan` varchar(10) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `bobot_persen` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kelas_makul`
--

INSERT INTO `kelas_makul` (`id`, `kode_akd`, `kode_makul`, `kode_jurusan`, `nik`, `nama_kelas`, `bobot_persen`) VALUES
(16, '03', '01', '01', '0620122', 'Mesin 1 B', 0),
(18, '03', '02', '03', '2450861', 'TI 1A', 0),
(22, '03', '01', '02', '24859641', 'TRET 2 B', 0),
(24, '11', '03', '02', '0620122', 'TRM 2B', 0),
(26, '11', '03', '01', '5421521', 'TRM 2B', 0),
(27, '01', '03', '01', '09562520', 'Mesin 1 A', 80);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kelamin` char(1) NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `kontak`, `email`, `kelamin`, `img`) VALUES
('010101', 'Xie Nui Loe Ming', '865274', 'goviii507@gmail.com', 'p', '../asset_web/img/foto_mhs1790925369.png'),
('0845120', 'Figo Firgiawan', '084120', 'OIKij@gmail.com', 'p', NULL),
('2458596354', 'Dimas Riyan Wirayudha', '020202', 'goviii507@gmail.com', 'l', '../asset_web/img/foto_mhs1790935333.png'),
('8745120', 'Rizki Febrian', '08845120', 'okm@gmai;.com', 'l', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id` int NOT NULL,
  `id_kelas` int NOT NULL,
  `tanggal` date NOT NULL,
  `judul_pertemuan` varchar(255) NOT NULL,
  `status_presensi` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pertemuan_ke` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pertemuan`
--

INSERT INTO `pertemuan` (`id`, `id_kelas`, `tanggal`, `judul_pertemuan`, `status_presensi`, `pertemuan_ke`) VALUES
(20, 21, '2026-09-07', 'Sinau Passing data collab with P Fajar', '0', 3),
(25, 17, '2026-09-28', 'CRUD DASAR', '0', 1),
(26, 27, '2026-09-29', 'CRUD DASAR', '0', 1),
(27, 27, '2026-09-30', 'PASSING DATA', '1', 2),
(28, 27, '2026-09-30', 'belajar cross authority', '1', 3),
(29, 27, '2026-09-30', 'belajar session', '1', 4),
(30, 27, '2026-09-30', 'belajar html', '1', 5),
(31, 27, '2026-09-30', 'belajar CSS', '0', 6),
(32, 27, '2026-10-02', 'Buat Controller admin', '0', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `nim` varchar(10) NOT NULL,
  `status_kehadiran` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `id_pertemuan`, `nim`, `status_kehadiran`) VALUES
(5, 17, '240302062', '4'),
(6, 17, '24088596', '2'),
(7, 18, '240302062', '3'),
(8, 18, '24088596', '3'),
(9, 20, '240302062', '2'),
(10, 20, '24088596', '3'),
(11, 22, '240302062', '1'),
(12, 22, '24088596', '1'),
(13, 24, '240302062', '2'),
(14, 24, '24088596', '3'),
(15, 25, '240302062', '1'),
(16, 26, '010101', '2'),
(17, 26, '2458596354', '1'),
(18, 27, '010101', '1'),
(19, 27, '2458596354', '1'),
(20, 28, '010101', '1'),
(21, 28, '2458596354', '1'),
(22, 29, '010101', '1'),
(23, 29, '2458596354', '1'),
(24, 30, '010101', '1'),
(25, 30, '2458596354', '1'),
(26, 31, '010101', '1'),
(27, 31, '2458596354', '1'),
(28, 32, '010101', '1'),
(29, 32, '2458596354', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jNjeWjxC4tJ0hPEYbME9bbh9JNx2orVtOEhaakV3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIzTE5tNTB4Q012bjVKSFFwbVN3b0ZkYkVTaE9vcXZ3eUdoVHBmUDlyIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluX2RldGFpbF9rZWxhc1wvMjciLCJyb3V0ZSI6ImFkbWluLmRldGFpbC5rZWxhcy5pbmRleCJ9LCJ1c2VyIjp7ImlkIjoxNCwidXNlcm5hbWUiOiJhZG1pbiIsIm5hbWEiOiJhZG1pbiBMVEUiLCJwZXJhbiI6ImEifX0=', 1791372541);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_akademik`
--

CREATE TABLE `tbl_akademik` (
  `kode_akd` varchar(10) NOT NULL,
  `semester` enum('GN','GL') NOT NULL,
  `tahun` char(4) NOT NULL,
  `is_active` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_akademik`
--

INSERT INTO `tbl_akademik` (`kode_akd`, `semester`, `tahun`, `is_active`) VALUES
('01', 'GN', '2026', '0'),
('11', 'GL', '2018', '0'),
('88', 'GN', '2088', '1'),
('99', 'GL', '2099', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_makul`
--

CREATE TABLE `tbl_makul` (
  `kode_makul` varchar(10) NOT NULL,
  `nama_makul` varchar(50) NOT NULL,
  `jml_sks` int NOT NULL,
  `jml_cpmk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_makul`
--

INSERT INTO `tbl_makul` (`kode_makul`, `nama_makul`, `jml_sks`, `jml_cpmk`) VALUES
('02', 'bahasa indonesia', 8, 6),
('03', 'Praktikum Basis Data', 3, 3),
('05', 'Jaringan Komputer', 6, 6),
('09', 'Gema tech', 3, 3),
('10', 'Gma TMi', 6, 6),
('11', 'Sejarah', 3, 3),
('12', 'KerKom', 3, 3),
('13', 'PKN', 3, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `peran` char(10) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `peran`, `pin`, `last_update`, `nama`) VALUES
(14, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'a', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2026-10-02 04:03:34', 'admin LTE'),
(1252, '745120', 'f0d7c846a13800be08b4513b36ae236fe25c613a', 'd', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-09-29 07:56:09', 'Bu Laura'),
(1253, '09562520', '8ffd13d5fd317ea48c8eeeb000b0778a4158f3a1', 'd', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-09-29 07:56:28', 'Pak Dimas'),
(1254, '5421521', '36002c5b6882114237dc4f73b96d8def9efb339b', 'd', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-09-29 07:56:49', 'Pak Fajar'),
(1255, '852542542', 'c7b4ecdd8c8c3c7b487a5a5254905e41ed1fadc2', 'd', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-09-29 07:57:14', 'Bu Novi'),
(1256, '2458596354', '5fb22fca6677e87972195c03246ffd97655b8005', 'm', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-09-29 07:58:47', 'Dimas Riyan Wirayudha'),
(1257, '010101', '57ca2dad17817a05249a192cc18ef326772df0d4', 'm', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-10-01 09:37:40', 'Xie Nui Loe Ming'),
(1258, '0845120', '09609b6dd5f581f8223a195ddacec44bdb8ee4be', 'm', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-10-07 04:06:58', 'Figo Firgiawan'),
(1259, '8745120', 'f487365bc7823723d5ddedb9fcd8f958a7936991', 'm', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2026-10-07 04:06:58', 'Rizki Febrian'),
(1260, '085120451', 'd2284f5cf6b95a8daa4f7bd505273aabc6cfa162', 'd', 'cedf41fccb586dc39e1ce34bb482f0afe557b49f', '2026-10-07 04:43:58', 'Bu rostika'),
(1261, '2685241', '277efba483bf37fb4127830deb1786a107489bd4', 'd', 'cedf41fccb586dc39e1ce34bb482f0afe557b49f', '2026-10-07 04:43:58', 'Pak Ambau');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `detail_kelas`
--
ALTER TABLE `detail_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`kode_jurusan`);

--
-- Indeks untuk tabel `kelas_makul`
--
ALTER TABLE `kelas_makul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tbl_akademik`
--
ALTER TABLE `tbl_akademik`
  ADD PRIMARY KEY (`kode_akd`);

--
-- Indeks untuk tabel `tbl_makul`
--
ALTER TABLE `tbl_makul`
  ADD PRIMARY KEY (`kode_makul`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_kelas`
--
ALTER TABLE `detail_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas_makul`
--
ALTER TABLE `kelas_makul`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1262;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
