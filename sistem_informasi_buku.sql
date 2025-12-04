-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Des 2025 pada 01.44
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
-- Database: `sistem_informasi_buku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `deskripsi`, `harga`, `stok`, `id_kategori`, `gambar`, `tanggal_input`) VALUES
(2, 'Laut Bercerita', 'Novel fiksi sejarah yang menceritakan kisah para aktivis mahasiswa yang diculik.', 95000, 30, 1, 'laut_bercerita.png', '2025-11-29 15:53:28'),
(3, 'Sapiens', 'Sejarah singkat umat manusia dari zaman batu hingga masa kini.', 150000, 45, 4, 'sapiens.png', '2025-11-28 15:53:28'),
(4, 'Atomic Habits', 'Cara mudah dan terbukti untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.', 85000, 70, 2, 'atomic_habits.png', '2025-11-27 16:11:54'),
(5, 'The Alchemist', 'Novel klasik tentang perjalanan seorang gembala mencari harta karun dan menemukan takdirnya.', 75000, 60, 1, 'the_alchemist.png', '2025-11-26 16:11:54'),
(6, 'Kosmos', 'Menggali misteri alam semesta, bintang, planet, dan asal mula kehidupan.', 180000, 25, 5, 'kosmos.png', '2025-11-25 16:11:54'),
(7, 'Sejarah Indonesia Modern 1200-2008', 'Analisis mendalam mengenai perkembangan sosial, politik, dan ekonomi Indonesia.', 210000, 15, 4, 'sejarah_indonesia.png', '2025-11-24 16:11:54'),
(8, 'Clean Code', 'Panduan esensial tentang bagaimana menulis kode yang bersih, mudah dibaca, dan mudah dikelola.', 135000, 40, 3, 'clean_code.png', '2025-11-23 16:11:54'),
(9, 'Dunia Sophie', 'Novel filosofi yang memperkenalkan sejarah filsafat Barat melalui kisah remaja.', 90000, 55, 1, 'dunia_sophie.png', '2025-11-22 16:11:54'),
(10, 'Deep Work', 'Aturan untuk fokus mendalam di dunia yang penuh gangguan.', 105000, 65, 2, 'deep_work.png', '2025-11-21 16:11:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `tanggal_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `tanggal_input`) VALUES
(1, 'Fiksi', '2025-11-28 22:52:23'),
(2, 'Non-Fiksi', '2025-11-28 22:52:23'),
(3, 'Teknologi', '2025-11-28 22:52:23'),
(4, 'Sejarah', '2025-11-28 22:52:23'),
(5, 'Sains', '2025-11-28 22:52:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'novi', 'novi@gmail.com', '$2y$10$L/yOvRIaEnWHwGoGrzAGT.u3C2nUgN55FwKh.kjEQcDthPZhS/e/a'),
(2, 'adawiyah', 'novi@upi.edu', '$2y$10$2dNOwl5PgAJnURnAVmbNXuAzyE4GwwD4EVjr995fkxikgifrVX8/a');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
