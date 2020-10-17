-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Okt 2020 pada 09.33
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_niaga_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_barang`
--

CREATE TABLE `t_barang` (
  `id_barang` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `foto_barang` varchar(255) NOT NULL,
  `harga_barang` int(20) NOT NULL,
  `banyak_barang` int(10) NOT NULL,
  `deskripsi_barang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_metode_bayar`
--

CREATE TABLE `t_metode_bayar` (
  `id_metode_bayar` int(11) NOT NULL,
  `nama_metode_bayar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pengguna`
--

CREATE TABLE `t_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('pengguna','admin') NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_pengguna`
--

INSERT INTO `t_pengguna` (`id_pengguna`, `nama_pengguna`, `email`, `nomor_telepon`, `password`, `level`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Asep Aldi Hidayat', 'aldyh128@gmail.com', '0895414747753', '$2y$10$kL/hOcNOpLYLH2MuaqOv2e9J59El2yCABYHt46XvrYloDFLMiLBCu', 'admin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_token`
--

CREATE TABLE `t_token` (
  `id_token` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_transaksi`
--

CREATE TABLE `t_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL,
  `id_metode_bayar` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_barang`
--
ALTER TABLE `t_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indeks untuk tabel `t_metode_bayar`
--
ALTER TABLE `t_metode_bayar`
  ADD PRIMARY KEY (`id_metode_bayar`);

--
-- Indeks untuk tabel `t_pengguna`
--
ALTER TABLE `t_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `t_token`
--
ALTER TABLE `t_token`
  ADD PRIMARY KEY (`id_token`);

--
-- Indeks untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pembeli` (`id_pembeli`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_metode_bayar` (`id_metode_bayar`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_barang`
--
ALTER TABLE `t_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_metode_bayar`
--
ALTER TABLE `t_metode_bayar`
  MODIFY `id_metode_bayar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pengguna`
--
ALTER TABLE `t_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `t_token`
--
ALTER TABLE `t_token`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_barang`
--
ALTER TABLE `t_barang`
  ADD CONSTRAINT `t_barang_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `t_pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD CONSTRAINT `t_transaksi_ibfk_1` FOREIGN KEY (`id_pembeli`) REFERENCES `t_pengguna` (`id_pengguna`),
  ADD CONSTRAINT `t_transaksi_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `t_barang` (`id_barang`),
  ADD CONSTRAINT `t_transaksi_ibfk_3` FOREIGN KEY (`id_metode_bayar`) REFERENCES `t_metode_bayar` (`id_metode_bayar`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
