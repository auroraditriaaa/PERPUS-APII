-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Sep 2026 pada 08.54
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
-- Database: `perpus_api`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$bTPsU4O74HPMyMTbgO3jVueuCuSPj1uWUzD5uYuVSh7IoysgcnvqK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `sampul` varchar(255) DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `penerbit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `kode_buku`, `sampul`, `judul`, `penulis`, `kategori`, `tahun_terbit`, `penerbit`) VALUES
(1, 'BK001', NULL, 'Laskar Pelangi', 'Andrea Hirata', 'Novel', '2005', 'Bentang Pustaka'),
(2, 'BK002', NULL, 'Bumi', 'Tere Liye', 'Novel', '2014', 'Gramedia'),
(3, 'BK003', NULL, 'Pemrograman PHP', 'Abdul Kadir', 'Teknologi', '2020', 'Andi'),
(4, 'BK004', NULL, 'Belajar HTML dan CSS', 'Jubilee Enterprise', 'Teknologi', '2021', 'Elex Media'),
(5, 'BK005', NULL, 'Dasar-Dasar JavaScript', 'Wahana Komputer', 'Teknologi', '2022', 'Andi'),
(6, 'BK006', NULL, 'Negeri 5 Menara', 'Ahmad Fuadi', 'Novel', '2009', 'Gramedia'),
(8, 'BK008', NULL, 'Cantik Itu Luka', 'Eka Kurniawan', 'Novel', '2002', 'Gramedia'),
(9, 'BK009', NULL, 'Algoritma dan Pemrograman', 'Rinaldi Munir', 'Teknologi', '2019', 'Informatika'),
(10, 'BK010', NULL, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Novel', '1980', 'Hasta Mitra'),
(13, 'BK011', NULL, 'One Piece', 'Eiichiro Oda', 'Komik', '1997', 'Gramedia'),
(17, 'BK014', NULL, 'Cinderella', 'aurora', 'Novel', '2018', 'Gramedia'),
(18, 'BK015', NULL, 'Sleeping Beauty', 'aurora', 'Novel', '2022', 'Gramedia'),
(19, 'BK016', NULL, 'Smurf', 'aurora', 'Novel', '2019', 'Gramedia');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
