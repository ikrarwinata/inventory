-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 30 Apr 2021 pada 02.28
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barcode_generator`
--

DROP TABLE IF EXISTS `barcode_generator`;
CREATE TABLE IF NOT EXISTS `barcode_generator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(250) DEFAULT NULL,
  `barcode_text` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barcode_generator`
--

INSERT INTO `barcode_generator` (`id`, `judul`, `barcode_text`) VALUES
(1, 'Bahan Ajar Mahasiswa Kesehatan Statistika Kesehatan', '330.9598'),
(2, 'buku ajar matematika', '1000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

DROP TABLE IF EXISTS `divisi`;
CREATE TABLE IF NOT EXISTS `divisi` (
  `id` varchar(100) NOT NULL,
  `nama_divisi` varchar(255) NOT NULL DEFAULT '',
  `kota` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `nama_divisi`, `kota`, `alamat`, `telepon`, `keterangan`) VALUES
('DIVS1618646127', 'PT. Divisi1', 'Padang', 'asdasdsad', '90909090909', ''),
('DIVS1618818622', 'Divisi 2', 'Padang', 'Alamat panjang sebagai sample asdqd qwq q s s s s s s s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s ss s', '+(62) 895-3162-3622', 'Vendor samplesss s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s'),
('DIVS1619688801', 'Divisi 3 asdas as', 'Padang', 'P', '+(62) 895-3162-0000', 'P'),
('DIVS1619746056', 'Skills lab', 'kuningan', 'ddsk', '99999', 'ok');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` varchar(100) NOT NULL,
  `invoice_keys` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoice`
--

INSERT INTO `invoice` (`id`, `id_transaksi`, `invoice_keys`) VALUES
(1, 'SALS16197024120', 1),
(2, 'SALS16197024121', 1),
(3, 'SALS16197024122', 1),
(4, 'SALS16197024123', 1),
(5, 'SALS16197131130', 2),
(6, 'SALS16197131131', 2),
(7, 'SALS16197131132', 2),
(8, 'SALS16197166640', 3),
(9, 'SALS16197166641', 3),
(10, 'SALS16197166642', 3),
(11, 'SALS16197461530', 4),
(12, 'SALS16197461531', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_master`
--

DROP TABLE IF EXISTS `kategori_master`;
CREATE TABLE IF NOT EXISTS `kategori_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `kategori_master`
--

INSERT INTO `kategori_master` (`id`, `nama_kategori`) VALUES
(5, 'Makanan'),
(6, 'Minuman'),
(7, 'Furniture'),
(8, 'Fn'),
(9, 'Maasdkanan'),
(10, 'asd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master`
--

DROP TABLE IF EXISTS `master`;
CREATE TABLE IF NOT EXISTS `master` (
  `id` varchar(100) NOT NULL,
  `barcode` varchar(100) DEFAULT '',
  `nama` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga` float NOT NULL DEFAULT 0,
  `kategori` int(11) NOT NULL,
  `satuan` int(11) NOT NULL,
  `berat` int(11) NOT NULL DEFAULT 0,
  `kadaluarsa` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `gedung` varchar(250) DEFAULT NULL,
  `ruangan` varchar(250) DEFAULT NULL,
  `posisi` varchar(250) DEFAULT NULL,
  `id_vendor` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fkKategoriMaster` (`kategori`) USING BTREE,
  KEY `fkSatuanMaster` (`satuan`) USING BTREE,
  KEY `fkVendorMaster` (`id_vendor`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `master`
--

INSERT INTO `master` (`id`, `barcode`, `nama`, `stok`, `harga`, `kategori`, `satuan`, `berat`, `kadaluarsa`, `foto`, `gedung`, `ruangan`, `posisi`, `id_vendor`) VALUES
('ASST1618662741', '123123', 'pocari sweat botol 250ml', 193, 6000, 6, 2, 250, 1654534800, NULL, NULL, NULL, NULL, 'VNDR1618646127'),
('ASST1618664014', '1231234', 'pocari sweat botol 550ml', 145, 19000, 5, 2, 550, 1650128400, './writable/uploads/product/1619543245_fa117ac392785670c4d4.jpg', NULL, NULL, NULL, 'VNDR1618646127'),
('ASST1618685294', '1231231', 'Kursi Kayu', 4, 150000, 7, 2, 12, 1621357200, './writable/uploads/product/1619542194_f86d8af7691b9309f4c6.png', 'Gedung A', 'ruangan 001', 'Rak b1', 'VNDR1618818622'),
('ASST1619542017', '999', 'barang1', 53, 500000, 7, 2, 1500, 1650992400, './writable/uploads/product/1619542124_cbdbce7a1cf2da61fe00.jpg', 'Gedung A', 'ruangan 001', 'Rak a1', 'VNDR1618818622'),
('ASST1619543157', '9999', 'barang 2', 96, 500000, 7, 2, 1233, 1651078800, './writable/uploads/product/1619543182_cc519ecfc04e50ca2fe4.png', 'Gedung A', 'ruangan 001', 'Rak b2', 'VNDR1618818622'),
('ASST1619547110', '1231233', 'barang 3', 100, 6000, 7, 3, 1000, 1651078800, NULL, 'Gedung B', 'ruangan 002', 'Rak a1', 'VNDR1618646127'),
('ASST1619743769', '123', 'Barang Sample 1', 345, 60000, 5, 4, 1000, 1651251600, NULL, 'Gedung A', 'ruangan 001', 'Rak a1', 'VNDR1618818622');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `master_history`
-- (Lihat di bawah untuk tampilan aktual)
--
DROP VIEW IF EXISTS `master_history`;
CREATE TABLE IF NOT EXISTS `master_history` (
`id_master` varchar(100)
,`id` varchar(100)
,`harga` float
,`operators` varchar(1)
,`quantity` int(11)
,`timestamps` int(11)
,`username` varchar(50)
,`id_suplier` varchar(100)
,`Riwayat` varchar(12)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `master_view`
-- (Lihat di bawah untuk tampilan aktual)
--
DROP VIEW IF EXISTS `master_view`;
CREATE TABLE IF NOT EXISTS `master_view` (
`kode_barang` varchar(100)
,`barcode` varchar(100)
,`nama` varchar(255)
,`stok` int(11)
,`harga` float
,`subtotal` double
,`kategori` int(11)
,`satuan` int(11)
,`berat` int(11)
,`kadaluarsa` int(11)
,`foto` text
,`gedung` varchar(250)
,`ruangan` varchar(250)
,`posisi` varchar(250)
,`id_vendor` varchar(100)
,`nama_kategori` varchar(255)
,`nama_satuan` varchar(100)
,`nama_vendor` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE IF NOT EXISTS `pembelian` (
  `id` varchar(100) NOT NULL,
  `id_master` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `harga` float NOT NULL DEFAULT 0,
  `timestamps` int(11) NOT NULL,
  `id_vendor` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fkVendorBeli` (`id_vendor`) USING BTREE,
  KEY `fkUserBeli` (`username`) USING BTREE,
  KEY `fkMasterBeli` (`id_master`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id`, `id_master`, `quantity`, `harga`, `timestamps`, `id_vendor`, `username`) VALUES
('PCHS1614595625', 'ASST1618664014', 10, 19000, 1614595647, 'VNDR1618646127', 'superadmin'),
('PCHS1618662733', 'ASST1618662741', 12, 6000, 1618662792, 'VNDR1618646127', 'superadmin'),
('PCHS1618663638', 'ASST1618662741', 10, 8000, 1618663694, 'VNDR1618646127', 'superadmin'),
('PCHS1618664008', 'ASST1618664014', 11, 19000, 1618664181, 'VNDR1618646127', 'superadmin'),
('PCHS1618664216', 'ASST1618662741', 1, 6000, 1618664277, 'VNDR1618646127', 'superadmin'),
('PCHS1618687546', 'ASST1618685294', 10, 15000, 1618687619, 'VNDR1618646127', 'superadmin'),
('PCHS1618739868', 'ASST1618662741', 100, 6000, 1618739883, 'VNDR1618646127', 'superadmin'),
('PCHS1619536039', 'ASST1618662741', 1, 6000, 1619536059, 'VNDR1618646127', 'superadmin'),
('PCHS1619536515', 'ASST1618662741', 51, 6000, 1619536524, 'VNDR1618646127', 'superadmin'),
('PCHS1619536716', 'ASST1618664014', 61, 19000, 1619536733, 'VNDR1618646127', 'superadmin'),
('PCHS1619536937', 'ASST1618664014', 41, 19000, 1619536970, 'VNDR1618646127', 'superadmin'),
('PCHS1619537079', 'ASST1618662741', 31, 6000, 1619537098, 'VNDR1618646127', 'superadmin'),
('PCHS1619543137', 'ASST1619543157', 9, 500000, 1619543182, 'VNDR1618818622', 'superadmin'),
('PCHS1619546786', 'ASST1618662741', 31, 6000, 1619546992, 'VNDR1618646127', 'superadmin'),
('PCHS1619547098', 'ASST1619547110', 1, 6000, 1619547137, 'VNDR1618646127', 'superadmin'),
('PCHS1619743764', 'ASST1619743769', 100, 60000, 1619743825, 'VNDR1618818622', 'superadmin'),
('PCHS1619743825', 'ASST1619743769', 250, 60000, 1619743852, 'VNDR1618818622', 'superadmin');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `pembelian_subtotal`
-- (Lihat di bawah untuk tampilan aktual)
--
DROP VIEW IF EXISTS `pembelian_subtotal`;
CREATE TABLE IF NOT EXISTS `pembelian_subtotal` (
`id` varchar(100)
,`id_master` varchar(100)
,`quantity` int(11)
,`harga` float
,`timestamps` int(11)
,`id_vendor` varchar(100)
,`username` varchar(50)
,`subtotal` double
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

DROP TABLE IF EXISTS `pengembalian`;
CREATE TABLE IF NOT EXISTS `pengembalian` (
  `id` varchar(100) NOT NULL,
  `id_penjualan` varchar(100) NOT NULL,
  `id_master` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `harga` float NOT NULL DEFAULT 0,
  `timestamps` int(11) NOT NULL,
  `id_divisi` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fkUserJual` (`username`) USING BTREE,
  KEY `fkMasterJual` (`id_master`) USING BTREE,
  KEY `fkDivisiJual` (`id_divisi`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `id_penjualan`, `id_master`, `quantity`, `harga`, `timestamps`, `id_divisi`, `username`) VALUES
('RTRN1619740812', 'SALS16197166642', 'ASST1619547110', 1, 6000, 1619716696, 'DIVS1619688801', 'superadmin'),
('RTRN1619740886', 'SALS16197131132', 'ASST1619547110', 1, 6000, 1619713138, 'DIVS1619688801', 'superadmin'),
('RTRN1619741207', 'SALS16197131132', 'ASST1619547110', 2, 6000, 1619713138, 'DIVS1619688801', 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE IF NOT EXISTS `penjualan` (
  `id` varchar(100) NOT NULL,
  `id_master` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `harga` float NOT NULL DEFAULT 0,
  `timestamps` int(11) NOT NULL,
  `id_divisi` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fkUserJual` (`username`) USING BTREE,
  KEY `fkMasterJual` (`id_master`) USING BTREE,
  KEY `fkDivisiJual` (`id_divisi`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id`, `id_master`, `quantity`, `harga`, `timestamps`, `id_divisi`, `username`) VALUES
('SALS1614595655', 'ASST1618685294', 4, 16000, 1614595683, 'DIVS1618646127', 'superadmin'),
('SALS1618695648', 'ASST1618662741', 23, 6000, 1618695740, 'DIVS1618646127', 'superadmin'),
('SALS1618739689', 'ASST1618662741', 1, 6000, 1618739699, 'DIVS1618646127', 'superadmin'),
('SALS1618739983', 'ASST1618662741', 12, 6000, 1618740023, 'DIVS1618646127', 'superadmin'),
('SALS1619537109', 'ASST1618664014', 11, 19000, 1619537128, 'DIVS1618646127', 'superadmin'),
('SALS1619609440', 'ASST1619547110', 10, 6000, 1619609543, 'DIVS1618818622', 'superadmin'),
('SALS1619609578', 'ASST1619542017', 10, 500000, 1619609602, 'DIVS1618818622', 'superadmin'),
('SALS1619609602', 'ASST1619543157', 32, 500000, 1619609633, 'DIVS1618818622', 'superadmin'),
('SALS1619670898', 'ASST1619542017', 5, 500000, 1619670930, 'DIVS1618646127', 'admin'),
('SALS1619677994', 'ASST1619542017', 11, 500000, 1619678013, 'DIVS1618646127', 'superadmin'),
('SALS16196971710', 'ASST1619542017', 3, 500000, 1619697214, 'DIVS1619688801', 'superadmin'),
('SALS16196971711', 'ASST1618662741', 4, 6000, 1619697214, 'DIVS1619688801', 'superadmin'),
('SALS16196971712', 'ASST1619542017', 7, 500000, 1619697214, 'DIVS1619688801', 'superadmin'),
('SALS16196980150', 'ASST1618662741', 2, 6000, 1619698059, 'DIVS1618818622', 'superadmin'),
('SALS16196980151', 'ASST1619547110', 1, 6000, 1619698059, 'DIVS1618818622', 'superadmin'),
('SALS16197024120', 'ASST1619542017', 3, 500000, 1619702455, 'DIVS1618646127', 'superadmin'),
('SALS16197024121', 'ASST1618685294', 4, 150000, 1619702455, 'DIVS1618646127', 'superadmin'),
('SALS16197024122', 'ASST1619542017', 3, 500000, 1619702455, 'DIVS1618646127', 'superadmin'),
('SALS16197024123', 'ASST1619547110', 1, 6000, 1619702455, 'DIVS1618646127', 'superadmin'),
('SALS16197131130', 'ASST1619542017', 1, 500000, 1619713137, 'DIVS1619688801', 'superadmin'),
('SALS16197131131', 'ASST1619543157', 3, 500000, 1619713138, 'DIVS1619688801', 'superadmin'),
('SALS16197131132', 'ASST1619547110', 3, 6000, 1619713138, 'DIVS1619688801', 'superadmin'),
('SALS1619716537', 'ASST1618685294', 1, 150000, 1619716569, 'DIVS1618818622', 'superadmin'),
('SALS1619716618', 'ASST1618662741', 1, 6000, 1619716632, 'DIVS1618646127', 'superadmin'),
('SALS16197166640', 'ASST1619542017', 1, 500000, 1619716696, 'DIVS1619688801', 'superadmin'),
('SALS16197166641', 'ASST1619543157', 1, 500000, 1619716696, 'DIVS1619688801', 'superadmin'),
('SALS16197166642', 'ASST1619547110', 0, 6000, 1619716696, 'DIVS1619688801', 'superadmin'),
('SALS1619746113', 'ASST1619542017', 2, 500000, 1619746129, 'DIVS1618646127', 'admin'),
('SALS16197461530', 'ASST1619542017', 1, 500000, 1619746234, 'DIVS1619746056', 'admin'),
('SALS16197461531', 'ASST1619743769', 5, 60000, 1619746234, 'DIVS1619746056', 'admin');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `penjualan_subtotal`
-- (Lihat di bawah untuk tampilan aktual)
--
DROP VIEW IF EXISTS `penjualan_subtotal`;
CREATE TABLE IF NOT EXISTS `penjualan_subtotal` (
`id` varchar(100)
,`id_master` varchar(100)
,`quantity` int(11)
,`harga` float
,`timestamps` int(11)
,`id_vendor` varchar(100)
,`username` varchar(50)
,`subtotal` double
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_perusahaan`
--

DROP TABLE IF EXISTS `profil_perusahaan`;
CREATE TABLE IF NOT EXISTS `profil_perusahaan` (
  `key_name` varchar(150) NOT NULL,
  `values_data` text NOT NULL,
  PRIMARY KEY (`key_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `profil_perusahaan`
--

INSERT INTO `profil_perusahaan` (`key_name`, `values_data`) VALUES
('nama_perusahaan', 'Inventory'),
('alamat_perusahaan', 'Jalan jalan yuuukksss, Rt.0 No.1 Kotak'),
('telepon_perusahaan', '09090909'),
('pengingat_kadaluarsa', '30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan_master`
--

DROP TABLE IF EXISTS `satuan_master`;
CREATE TABLE IF NOT EXISTS `satuan_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(100) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `satuan_master`
--

INSERT INTO `satuan_master` (`id`, `nama_satuan`) VALUES
(2, 'Pcs'),
(3, 'Kg'),
(4, 'Dus'),
(5, 'Lusin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` enum('admin','superadmin') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `nama`, `level`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin2', 'admin'),
('admin2', 'c84258e9c39059a89ab77d846ddab909', 'admin2', 'admin'),
('superadmin', '17c4520f6cfd1ab53d8745e84681eb49', 'superadministrator', 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vendor`
--

DROP TABLE IF EXISTS `vendor`;
CREATE TABLE IF NOT EXISTS `vendor` (
  `id` varchar(100) NOT NULL,
  `nama_vendor` varchar(255) NOT NULL DEFAULT '',
  `kota` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `vendor`
--

INSERT INTO `vendor` (`id`, `nama_vendor`, `kota`, `alamat`, `telepon`, `keterangan`) VALUES
('VNDR1618646127', 'PT.Wingsfood', 'Padang', 'asdasdsad', '90909090909', ''),
('VNDR1618818622', 'PT.Sample1', 'Padang', 'Alamat panjang sebagai sample asdqd qwq q s s s s s s s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s ss s', '+(62) 895-3162-3622', 'Vendor samplesss s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s s ss  ss s s  ss s s s s s  ss s');

-- --------------------------------------------------------

--
-- Struktur untuk view `master_history`
--
DROP TABLE IF EXISTS `master_history`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `master_history`  AS  (select `pembelian`.`id_master` AS `id_master`,`pembelian`.`id` AS `id`,`pembelian`.`harga` AS `harga`,'+' AS `operators`,`pembelian`.`quantity` AS `quantity`,`pembelian`.`timestamps` AS `timestamps`,`pembelian`.`username` AS `username`,`pembelian`.`id_vendor` AS `id_suplier`,'Pembelian' AS `Riwayat` from `pembelian`) union all (select `penjualan`.`id_master` AS `id_master`,`penjualan`.`id` AS `id`,`penjualan`.`harga` AS `harga`,'-' AS `operators`,`penjualan`.`quantity` AS `quantity`,`penjualan`.`timestamps` AS `timestamps`,`penjualan`.`username` AS `username`,`penjualan`.`id_divisi` AS `id_suplier`,'Pengeluaran' AS `Riwayat` from `penjualan`) union all (select `pengembalian`.`id_master` AS `id_master`,`pengembalian`.`id` AS `id`,`pengembalian`.`harga` AS `harga`,'+' AS `operators`,`pengembalian`.`quantity` AS `quantity`,`pengembalian`.`timestamps` AS `timestamps`,`pengembalian`.`username` AS `username`,`pengembalian`.`id_divisi` AS `id_suplier`,'Pengembalian' AS `Riwayat` from `pengembalian`) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `master_view`
--
DROP TABLE IF EXISTS `master_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `master_view`  AS  select `master`.`id` AS `kode_barang`,`master`.`barcode` AS `barcode`,`master`.`nama` AS `nama`,`master`.`stok` AS `stok`,`master`.`harga` AS `harga`,`master`.`stok` * `master`.`harga` AS `subtotal`,`master`.`kategori` AS `kategori`,`master`.`satuan` AS `satuan`,`master`.`berat` AS `berat`,`master`.`kadaluarsa` AS `kadaluarsa`,`master`.`foto` AS `foto`,`master`.`gedung` AS `gedung`,`master`.`ruangan` AS `ruangan`,`master`.`posisi` AS `posisi`,`master`.`id_vendor` AS `id_vendor`,`kategori_master`.`nama_kategori` AS `nama_kategori`,`satuan_master`.`nama_satuan` AS `nama_satuan`,`vendor`.`nama_vendor` AS `nama_vendor` from (((`master` left join `kategori_master` on(`master`.`kategori` = `kategori_master`.`id`)) left join `satuan_master` on(`master`.`satuan` = `satuan_master`.`id`)) left join `vendor` on(`master`.`id_vendor` = `vendor`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `pembelian_subtotal`
--
DROP TABLE IF EXISTS `pembelian_subtotal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pembelian_subtotal`  AS  select `pembelian`.`id` AS `id`,`pembelian`.`id_master` AS `id_master`,`pembelian`.`quantity` AS `quantity`,`pembelian`.`harga` AS `harga`,`pembelian`.`timestamps` AS `timestamps`,`pembelian`.`id_vendor` AS `id_vendor`,`pembelian`.`username` AS `username`,`pembelian`.`quantity` * `pembelian`.`harga` AS `subtotal` from `pembelian` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `penjualan_subtotal`
--
DROP TABLE IF EXISTS `penjualan_subtotal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `penjualan_subtotal`  AS  select `penjualan`.`id` AS `id`,`penjualan`.`id_master` AS `id_master`,`penjualan`.`quantity` AS `quantity`,`penjualan`.`harga` AS `harga`,`penjualan`.`timestamps` AS `timestamps`,`penjualan`.`id_divisi` AS `id_vendor`,`penjualan`.`username` AS `username`,`penjualan`.`quantity` * `penjualan`.`harga` AS `subtotal` from `penjualan` ;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master`
--
ALTER TABLE `master`
  ADD CONSTRAINT `fkKategoriMaster` FOREIGN KEY (`kategori`) REFERENCES `kategori_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkSatuanMaster` FOREIGN KEY (`satuan`) REFERENCES `satuan_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkVendorMaster` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fkMasterBeli` FOREIGN KEY (`id_master`) REFERENCES `master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkUserBeli` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkVendorBeli` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `fkDivisiJual` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkMasterJual` FOREIGN KEY (`id_master`) REFERENCES `master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkUserJual` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
