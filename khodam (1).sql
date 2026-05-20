-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2026 pada 01.12
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
-- Database: `khodam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `khodam`
--

CREATE TABLE `khodam` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `alamat` text NOT NULL,
  `tanggal` date NOT NULL,
  `hari` text NOT NULL,
  `weton` text NOT NULL,
  `namakhodam` varchar(300) NOT NULL,
  `fotokhodam` text NOT NULL,
  `ketkhodam` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `khodam`
--

INSERT INTO `khodam` (`id`, `nama`, `alamat`, `tanggal`, `hari`, `weton`, `namakhodam`, `fotokhodam`, `ketkhodam`) VALUES
(1, 'abduh', 'jogja', '2007-08-13', 'Senin', 'Pahing', 'Bebek Sumbing', 'uploads/foto_1776516546.jpg', 'bebeks'),
(2, 'budi', 'jogja', '2001-12-12', 'Senin', 'Kliwon', 'Tuyul Mulet', '', ''),
(3, 'abduh', 'jogja', '2007-08-13', 'Senin', 'Wage', 'Pocong Bersepeda', 'https://cdn1-production-images-kly.akamaized.net/CWgi38bLm-tw771ITv0X7YRdCkg=/640x640/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/5199105/original/018810000_1745567836-Gambar_WhatsApp_2025-04-25_pukul_14.45.16_1ee4d9ff.jpg', ''),
(4, 'niki', 'nskdsjd', '2026-05-11', 'Kamis', 'Pahing', 'Tuyul Part-time', '', ''),
(5, 'niki', 'surabaya', '2026-05-11', 'Sabtu', 'Pahing', 'Tumis Kangkung', '', ''),
(6, '', '', '0000-00-00', '', '', 'Tali Jemuran', '', ''),
(7, '', '', '0000-00-00', '', '', 'Pocong Vlogger', '', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `khodam`
--
ALTER TABLE `khodam`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `khodam`
--
ALTER TABLE `khodam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
