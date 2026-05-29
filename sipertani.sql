-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Bulan Mei 2026 pada 15.21
-- Versi server: 8.0.30
-- Versi PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pertanian_cerdas`
--

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
  `role` enum('petani','penyuluh','dinas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petani',
  `wilayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `wilayah`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'bimaa', 'bimaa@gmail.com', NULL, '$2y$12$iMcaQidjIanqhX37/1FPReABPu67aWURItC2PTIKaqCW/dI.xIZgq', 'petani', 'Surabaya, Jawa Timur', NULL, NULL, '2026-05-29 02:50:09', '2026-05-29 02:50:09'),
(13, 'bimaaa', 'bimaaa@gmail.com', NULL, '$2y$12$JDyzaPhvePOxDjHtRyF9EORbuLHky3VXmnLYSuZ1Rwwcz.IsoaJLu', 'penyuluh', 'Surabaya, Jawa Timur', NULL, NULL, '2026-05-29 02:53:00', '2026-05-29 02:53:00'),
(14, 'Dinas Pertanian Jawa Timur', 'dinasjatim@gmail.com', NULL, '$2y$12$TAZOAODwc1kWliDJW8JXj.hYJ65HYytHKhgY3xuTyDv0iKFLwChcu', 'dinas', 'Jawa Timur', 'Dinas Pertanian dan Perkebunan Provinsi Jawa Timur.', NULL, '2026-05-29 03:16:29', '2026-05-29 03:16:29'),
(15, 'bima', 'bima@gmail.com', NULL, '$2y$12$iMk6ctlofgtSEF1kJTDKAu6f23QzuIFjZKEbhwzC/9hc2gr09HaVq', 'petani', 'Bekasi, Jawa Barat', NULL, NULL, '2026-05-29 06:50:26', '2026-05-29 08:17:51'),
(16, 'ahnaf', 'ahnaf@gmail.com', NULL, '$2y$12$RSqHYRcH5fmaE1Gjl3CtWum4uuLLfebKnB0Y9cS6khYTmLl5IipOK', 'petani', 'Semarang, Jawa Timur', NULL, NULL, '2026-05-29 07:55:53', '2026-05-29 08:17:45');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
