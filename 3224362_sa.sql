-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: fdb16.awardspace.net
-- Generation Time: Nov 16, 2019 at 05:25 PM
-- Server version: 5.7.20-log
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3224362_sa`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id_account` varchar(10) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `notlpn` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id_account`, `nama_lengkap`, `username`, `password`, `alamat`, `notlpn`, `npwp`, `email`, `gambar`) VALUES
('a000000000', 'sa', 'sa', '8b1c8c401df4385320645accee0922a71bc73f611417ed4778e2d803facd98faef6273cfcb160d8a320540a53d2c62c328dd1ce724605991b218127990a690d8', '', '', '', '', ''),
('a000000001', 'cobain', 'cobain', '8b1c8c401df4385320645accee0922a71bc73f611417ed4778e2d803facd98faef6273cfcb160d8a320540a53d2c62c328dd1ce724605991b218127990a690d8', 'alamat1', '', '', '', 'a000000001.jpg'),
('a000000002', 'lydyaa', 'lydyaa', '8b1c8c401df4385320645accee0922a71bc73f611417ed4778e2d803facd98faef6273cfcb160d8a320540a53d2c62c328dd1ce724605991b218127990a690d8', '', '', '', '', ''),
('a000000003', 'suriyani', 'anikkk', '8b1c8c401df4385320645accee0922a71bc73f611417ed4778e2d803facd98faef6273cfcb160d8a320540a53d2c62c328dd1ce724605991b218127990a690d8', 'medan', '', '', '', 'a000000003.jpg'),
('a000000006', 'hendry', 'hendry', '8b1c8c401df4385320645accee0922a71bc73f611417ed4778e2d803facd98faef6273cfcb160d8a320540a53d2c62c328dd1ce724605991b218127990a690d8', 'medan', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('5fa4b833fdffe4e2e0c498c25fbdef24ce3af51c', '140.213.135.48', 1573922327, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932323332373b),
('f27b2884685b93f53ecadc0ad6ad11f1b10cece0', '140.213.135.48', 1573922638, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932323633383b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a303a22223b),
('d8b83ed2db8abfea031dbf0feabd25f8b67a8766', '140.213.135.48', 1573923082, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932333038323b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a303a22223b),
('4823277764fb1d424c671c1143fe88ebc6ffcd24', '140.213.135.48', 1573923423, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932333432333b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a31333a2235646430323965633738643933223b),
('f7b755312879bb6e803882aac92069584a4d0184', '140.213.135.48', 1573924040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932343034303b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a31333a2235646430326232323832383630223b70656d62656c69616e7c733a36353a223c64697620636c6173733d22616c65727420616c6572742d7375636365737320746578742d63656e746572223e426572686173696c20496e7075743c2f6469763e223b5f5f63695f766172737c613a313a7b733a393a2270656d62656c69616e223b733a333a226e6577223b7d),
('0f6bb2d597e9222a60a6f3f36a76beb418f703e6', '140.213.135.48', 1573924364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932343336343b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a31333a2235646430326439373662613466223b),
('8e582d4d5962766ea82759182d211579c719e217', '140.213.135.48', 1573925009, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932353030393b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a31333a2235646430326561316135656333223b70656d6261796172616e7c733a36353a223c64697620636c6173733d22616c65727420616c6572742d7375636365737320746578742d63656e746572223e426572686173696c20496e7075743c2f6469763e223b5f5f63695f766172737c613a313a7b733a31303a2270656d6261796172616e223b733a333a226f6c64223b7d),
('e8b1c5edf4f059b8e2b8973e92367c0869703f77', '140.213.135.48', 1573925019, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333932353030393b69645f6163636f756e747c733a31303a2261303030303030303030223b757365726e616d657c733a323a227361223b6e616d615f6c656e676b61707c733a323a227361223b67616d6261727c733a303a22223b666f726d5f6b65797c733a303a22223b);

-- --------------------------------------------------------

--
-- Table structure for table `custom`
--

CREATE TABLE `custom` (
  `id_kategori` varchar(10) NOT NULL,
  `id_custom` varchar(10) NOT NULL,
  `opsi` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `custom`
--

INSERT INTO `custom` (`id_kategori`, `id_custom`, `opsi`, `keterangan`) VALUES
('k0003', 'c000000002', 'customer', 'test'),
('k0003', 'c000000003', 'supplier', ''),
('k0001', 'c000000004', 'engsel', ''),
('k0001', 'c000000003', 'gembok', ''),
('k0001', 'c000000002', 'mesin', ''),
('k0001', 'c000000005', 'pipa/sambungan pipa', ''),
('k0001', 'c000000006', 'alat-alat bangunan', ''),
('k0004', 'c000000001', 'kg', ''),
('k0004', 'c000000002', 'unit', ''),
('k0004', 'c000000003', 'klg', ''),
('k0004', 'c000000004', 'lsn', ''),
('k0004', 'c000000005', 'gross', ''),
('k0004', 'c000000006', 'pcs', ''),
('k0004', 'c000000007', 'dus', ''),
('k0001', 'c000000007', 'keramik', ''),
('k0004', 'c000000008', 'roll', ''),
('k0003', 'c000000002', 'sales', ''),
('k0001', 'c000000008', 'selang', ''),
('k0004', 'c000000009', 'ktk', ''),
('k0004', 'c000000010', 'bks', ''),
('k0004', 'c000000011', 'gln', ''),
('k0001', 'c000000010', 'ingco', ''),
('k0004', 'c000000012', 'set', ''),
('k0004', 'c000000013', 'btl', ''),
('k0004', 'c000000014', 'lbr', ''),
('k0004', 'c000000015', 'psng', ''),
('k0004', 'c000000016', 'zak', ''),
('k0004', 'c000000017', 'pail', ''),
('k0004', 'c000000018', 'btg', ''),
('k0004', 'c000000019', 'bal', ''),
('k0004', 'c000000020', 'bh', ''),
('k0004', 'c000000021', 'psg', ''),
('k0004', 'c000000022', 'goni', '');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembayaran`
--

CREATE TABLE `detail_pembayaran` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembayaran` varchar(255) NOT NULL,
  `id_transaksi` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_pembelian` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_pembelian`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES
('b000000001', 'i000000001', 12000, 10.00, '10', 119990, '', '900000000001'),
('b000000005', 'i000000003', 5000, 5.00, '5%', 23750, '', '900000000006');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_penjualan` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_penjualan`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES
('j000000001', 'i000000001', 15000, 2.00, '10', 29990, '', '900000000001');

-- --------------------------------------------------------

--
-- Table structure for table `detail_retur_beli`
--

CREATE TABLE `detail_retur_beli` (
  `id_retur_beli` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_retur_jual`
--

CREATE TABLE `detail_retur_jual` (
  `id_retur_jual` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `group` text NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id_item`, `nama`, `harga_beli`, `diskon`, `satuan`, `group`, `keterangan`, `gambar`) VALUES
('i000000001', 'item1', 8000, '0', 'kg', 'engsel', '', ''),
('i000000002', 'item2', 4000, '0', 'pail', 'selang', '', ''),
('i000000003', 'item3', 9999, '0', 'gln', 'selang', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(10) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('K0001', 'Kategori'),
('K0002', 'Lokasi'),
('K0003', 'Jenis'),
('K0004', 'Satuan');

-- --------------------------------------------------------

--
-- Table structure for table `log_account`
--

CREATE TABLE `log_account` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_account` varchar(10) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `notlpn` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_account`
--

INSERT INTO `log_account` (`tgl_input`, `user_input`, `id_account`, `nama_lengkap`, `username`, `password`, `alamat`, `notlpn`, `npwp`, `email`, `gambar`) VALUES
('2018-10-16 07:08:33', 'a000000000', 'a000000000', 'sa', 'sa', '1295123972b3d47762887a04255679df4bf3b89554525914bdcdf509eca3ebfbec010f475569711f8f2bbc7e1d5fb2ce20203634d48257ab9c45669add48644c', '', '', '', '', ''),
('2018-10-16 07:08:33', 'a000000000', 'a000000001', 'cobain', 'cobain', 'db0bdc88300add1a4551b3340e980b3f66cee1d99fcb086ac3c2ac28079f6fef9f35ae6ad112d62e1f50bc2fe0f1dbd0aba4ccb5e333cb5e74c5697a50078ba2', 'alamat1', '', '', '', 'a000000001.jpg'),
('2018-10-16 07:08:33', 'a000000000', 'a000000002', 'lydyaa', 'lydyaa', '97a9b44bd6e4d7f7ad5ce7223125652e505fb41f5e10105ab00faaaa006dc760ee2d7f17a7f60117e58a0d6e7e51af14ecf2f45d46da3fdefe57f81f0ed86c94', '', '', '', '', ''),
('2018-10-16 07:08:33', 'a000000000', 'a000000003', 'cobain1', 'cobain1', 'bcb7ad55feb1217b9cfa78edffc0747d3ac6b8ed50196cc786b1068e042731035ef2c297fa7f0a0fc568fa688c79065c49c85cc19a70159a316d07c9fc3c3c43', '', '', '', '', 'a000000003.jpg'),
('2018-10-16 07:08:33', 'a000000000', 'a000000004', 'cobain2', 'cobain2', 'ddc018851ff49ef0e19cef2ec267e82f243624e7dab671e45cf699aab22d94f09c52391346b065598bd65db5fbe38deb661f1298c66a474e715621e26380972f', '', '', '', '', ''),
('2018-12-12 17:18:59', 'a000000000', 'a000000005', 'coba99', 'coba99', '4a1d4a12281cf6b046066e00133b08e65d62d9e26b1a59dea52fe7839573725327ab08ec6e7e7519f4a26484429039a88f9b00ab0304660f07de050c516dc219', '', '', '', '', ''),
('2018-12-28 10:54:21', 'a000000001', 'a000000003', 'suriyani', 'anikkk', '84a7ff7e52d2f049b9bc5b1d375af95e013ed437bef9bd1ac03b06f900c2dd7a502c4a23e259d782fdeb06f769aab4416697cd62ef2d1b594f414162a5aecb89', 'medan', '', '', '', 'a000000003.jpg'),
('2019-01-10 21:30:36', 'a000000001', 'a000000006', 'hendry', 'hendry', 'db0bdc88300add1a4551b3340e980b3f66cee1d99fcb086ac3c2ac28079f6fef9f35ae6ad112d62e1f50bc2fe0f1dbd0aba4ccb5e333cb5e74c5697a50078ba2', 'medan', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_custom`
--

CREATE TABLE `log_custom` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_kategori` varchar(10) NOT NULL,
  `id_custom` varchar(10) NOT NULL,
  `opsi` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_custom`
--

INSERT INTO `log_custom` (`tgl_input`, `user_input`, `id_kategori`, `id_custom`, `opsi`, `keterangan`) VALUES
('2018-10-16 07:09:02', 'a000000000', 'k0003', 'c000000002', 'customer', 'test'),
('2018-10-16 07:09:02', 'a000000000', 'k0003', 'c000000003', 'supplier', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000004', 'engsel', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000003', 'gembok', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000002', 'mesin', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000005', 'pipa/sambungan pipa', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000006', 'alat-alat bangunan', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000001', 'kg', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000002', 'unit', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000003', 'klg', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000004', 'lsn', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000005', 'gross', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000006', 'pcs', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000007', 'dus', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000007', 'keramik', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000008', 'roll', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0003', 'c000000002', 'sales', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000008', 'selang', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000009', 'ktk', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000010', 'bks', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0004', 'c000000011', 'gln', ''),
('2018-10-16 07:09:02', 'a000000000', 'k0001', 'c000000010', 'ingco', ''),
('2018-12-13 12:55:38', 'a000000001', 'k0004', 'c000000012', 'set', ''),
('2018-12-21 21:30:14', 'a000000001', 'k0004', 'c000000013', 'btl', ''),
('2018-12-25 09:42:39', 'a000000002', 'k0004', 'c000000014', 'lbr', ''),
('2018-12-28 21:15:55', 'a000000001', 'k0004', 'c000000015', 'psng', ''),
('2019-01-01 21:38:42', 'a000000001', 'k0004', 'c000000016', 'zak', ''),
('2019-01-09 13:55:43', 'a000000001', 'k0004', 'c000000017', 'pail', ''),
('2019-01-17 12:42:14', 'a000000006', 'k0004', 'c000000018', 'btg', ''),
('2019-02-09 15:05:05', 'a000000006', 'k0004', 'c000000019', 'bal', ''),
('2019-03-06 11:12:17', 'a000000002', 'k0004', 'c000000020', 'bh', ''),
('2019-07-18 18:09:49', 'a000000002', 'k0004', 'c000000021', 'psg', ''),
('2019-10-05 09:50:38', 'a000000002', 'k0004', 'c000000022', 'goni', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_detail_pembayaran`
--

CREATE TABLE `log_detail_pembayaran` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembayaran` varchar(255) NOT NULL,
  `id_transaksi` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_detail_pembelian`
--

CREATE TABLE `log_detail_pembelian` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembelian` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_detail_pembelian`
--

INSERT INTO `log_detail_pembelian` (`tgl_input`, `user_input`, `id_pembelian`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES
('2019-11-16 23:57:03', 'a000000000', 'b000000001', 'i000000001', 12000, 10.00, '10', 119990, '', '900000000001'),
('2019-11-16 23:58:22', 'a000000000', 'b000000002', 'i000000003', 5000, 50.00, '0', 250000, '', '900000000002'),
('2019-11-16 23:58:22', 'a000000000', 'b000000002', 'i000000002', 8000, 15.00, '5%', 114000, '', '900000000003'),
('2019-11-16 23:59:32', 'a000000000', 'b000000003', 'i000000003', 4000, 15.00, '5%', 57000, '', '900000000004'),
('2019-11-17 00:00:40', 'a000000000', 'b000000004', 'i000000003', 5000, 5.00, '5%', 23750, '', '900000000005'),
('2019-11-17 00:07:50', 'a000000000', 'b000000005', 'i000000003', 5000, 5.00, '5%', 23750, '', '900000000006');

-- --------------------------------------------------------

--
-- Table structure for table `log_detail_penjualan`
--

CREATE TABLE `log_detail_penjualan` (
  `tgl_input` varchar(255) DEFAULT NULL,
  `user_input` varchar(255) DEFAULT NULL,
  `id_penjualan` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` double NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_detail_penjualan`
--

INSERT INTO `log_detail_penjualan` (`tgl_input`, `user_input`, `id_penjualan`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES
('2019-11-17 00:11:26', 'a000000000', 'j000000001', 'i000000001', 15000, 2.00, 10, 29990, '', '900000000001');

-- --------------------------------------------------------

--
-- Table structure for table `log_detail_retur_beli`
--

CREATE TABLE `log_detail_retur_beli` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_retur_beli` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_detail_retur_jual`
--

CREATE TABLE `log_detail_retur_jual` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_retur_jual` varchar(255) NOT NULL,
  `id_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` decimal(7,2) DEFAULT NULL,
  `diskon` varchar(255) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `batch` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_item`
--

CREATE TABLE `log_item` (
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(255) DEFAULT NULL,
  `id_item` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `group` text NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_item`
--

INSERT INTO `log_item` (`tgl_input`, `user_input`, `id_item`, `nama`, `harga_beli`, `diskon`, `satuan`, `group`, `keterangan`, `gambar`) VALUES
('2019-11-16 23:54:10', 'a000000000', 'i000000001', 'item1', 8000, '0', 'kg', 'engsel', '', ''),
('2019-11-16 23:54:23', 'a000000000', 'i000000002', 'item2', 4000, '0', '', 'selang', '', ''),
('2019-11-16 23:54:31', 'a000000000', 'i000000002', 'item2', 4000, '0', 'pail', 'selang', '', ''),
('2019-11-16 23:54:50', 'a000000000', 'i000000003', 'item3', 9999, '0', 'gln', 'selang', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_pembayaran`
--

CREATE TABLE `log_pembayaran` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembayaran` varchar(255) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `id_person` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` text NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_pembayaran`
--

INSERT INTO `log_pembayaran` (`tgl_input`, `user_input`, `id_pembayaran`, `tgl_pembayaran`, `id_person`, `nominal`, `keterangan`, `gambar`, `flag`) VALUES
('2019-11-17 00:15:28', 'a000000000', 'y000000001', '2019-04-19', 'p000000001', 5000, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_pembelian`
--

CREATE TABLE `log_pembelian` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembelian` varchar(255) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `id_supplier` varchar(255) NOT NULL,
  `no_bon` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `gambar` text NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_pembelian`
--

INSERT INTO `log_pembelian` (`tgl_input`, `user_input`, `id_pembelian`, `tgl_pembelian`, `id_supplier`, `no_bon`, `tgl_TOP`, `gambar`, `diskon`, `keterangan`) VALUES
('2019-11-16 23:57:03', 'a000000000', 'b000000001', '2019-11-08', 'p000000001', 'bon1', '2019-12-08', '', '0', ''),
('2019-11-16 23:58:22', 'a000000000', 'b000000002', '2019-11-29', 'p000000001', 'bon2', '2020-02-27', '', '10%', ''),
('2019-11-16 23:59:32', 'a000000000', 'b000000003', '2019-11-21', 'p000000001', 'bon2', '2020-02-19', '', '10%', ''),
('2019-11-17 00:00:40', 'a000000000', 'b000000004', '2019-11-21', 'p000000001', 'bon2', '2020-02-19', '', '10%', ''),
('2019-11-17 00:07:50', 'a000000000', 'b000000005', '2019-11-06', 'p000000001', 'bon2', '2020-02-04', '', '10%', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_penjualan`
--

CREATE TABLE `log_penjualan` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_penjualan` varchar(255) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `id_customer` varchar(255) NOT NULL,
  `id_sales` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `diskon` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_penjualan`
--

INSERT INTO `log_penjualan` (`tgl_input`, `user_input`, `id_penjualan`, `tgl_penjualan`, `id_customer`, `id_sales`, `tgl_TOP`, `diskon`, `keterangan`) VALUES
('2019-11-17 00:11:26', 'a000000000', 'j000000001', '2019-11-13', 'p000000002', 'p000000003', '2020-01-12', 10, '');

-- --------------------------------------------------------

--
-- Table structure for table `log_person`
--

CREATE TABLE `log_person` (
  `tgl_input` datetime DEFAULT NULL,
  `user_input` varchar(255) DEFAULT NULL,
  `id_person` varchar(10) NOT NULL,
  `nama_person` varchar(255) NOT NULL,
  `jenis` text NOT NULL,
  `notlpn` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_person`
--

INSERT INTO `log_person` (`tgl_input`, `user_input`, `id_person`, `nama_person`, `jenis`, `notlpn`, `alamat`, `npwp`, `gambar`) VALUES
('2019-11-16 23:55:04', 'a000000000', 'p000000001', 'supplier1', 'supplier', '', '', '', ''),
('2019-11-16 23:55:56', 'a000000000', 'p000000002', 'customer1', 'customer', '', '', '', ''),
('2019-11-17 00:10:17', 'a000000000', 'p000000003', 'sales1', 'sales', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_retur_beli`
--

CREATE TABLE `log_retur_beli` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_retur_beli` varchar(255) NOT NULL,
  `tgl_retur_beli` date NOT NULL,
  `id_supplier` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_retur_jual`
--

CREATE TABLE `log_retur_jual` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_retur_jual` varchar(255) NOT NULL,
  `tgl_retur_jual` date NOT NULL,
  `id_customer` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_account` varchar(255) NOT NULL,
  `bagian` text NOT NULL,
  `hak` text NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_account`, `bagian`, `hak`, `flag`) VALUES
('a000000001', 'account', 'view, baru, edit, hapus', 0),
('a000000001', 'custom', 'view, baru, edit, hapus', 0),
('a000000001', 'item', 'view, baru, edit, hapus', 0),
('a000000001', 'person', 'view, baru, edit, hapus', 0),
('a000000001', 'pembelian', 'view, baru, edit, hapus', 0),
('a000000001', 'penjualan', 'view, baru, edit, hapus', 0),
('a000000001', 'retur_jual', 'view, baru, edit, hapus', 0),
('a000000001', 'retur_beli', 'view, baru, edit, hapus', 0),
('a000000001', 'pembayaran', 'view, bayar, edit, hapus', 0),
('a000000001', 'report', 'view', 0),
('a000000001', 'hak_akses', 'view, edit', 0),
('a000000002', 'custom', 'view, baru', 0),
('a000000002', 'item', 'view, baru, edit', 0),
('a000000002', 'person', 'view, baru, edit', 0),
('a000000002', 'pembelian', 'view, baru, edit', 0),
('a000000002', 'penjualan', 'view, baru, edit', 0),
('a000000002', 'retur_beli', 'view, baru, edit', 0),
('a000000002', 'pembayaran', 'view', 0),
('a000000002', 'report', 'view', 0),
('a000000006', 'account', 'view, baru, edit', 0),
('a000000006', 'custom', 'view, baru, edit', 0),
('a000000006', 'item', 'view, baru, edit', 0),
('a000000006', 'person', 'view, baru, edit', 0),
('a000000006', 'pembelian', 'view, baru, edit', 0),
('a000000006', 'penjualan', 'view, baru, edit', 0),
('a000000006', 'retur_beli', 'view, baru, edit', 0),
('a000000006', 'retur_jual', 'view, baru, edit', 0),
('a000000006', 'pembayaran', 'view, bayar, edit', 0),
('a000000006', 'report', 'view', 0),
('a000000006', 'hak_akses', 'view, edit', 0),
('a000000003', 'item', 'view, baru, edit', 0),
('a000000003', 'person', 'view, baru, edit', 0),
('a000000003', 'pembelian', 'view, baru', 0),
('a000000003', 'penjualan', 'view, baru, edit', 0),
('a000000003', 'retur_beli', 'view, baru', 0),
('a000000003', 'retur_jual', 'view, baru', 0),
('a000000003', 'pembayaran', 'view, bayar, edit', 0),
('a000000003', 'report', 'view', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembayaran` varchar(255) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `id_person` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` text NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`tgl_input`, `user_input`, `id_pembayaran`, `tgl_pembayaran`, `id_person`, `nominal`, `keterangan`, `gambar`, `flag`) VALUES
('2019-11-17 00:15:28', 'a000000000', 'y000000001', '2019-04-19', 'p000000001', 5000, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_pembelian` varchar(255) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `id_supplier` varchar(255) NOT NULL,
  `no_bon` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `gambar` text NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`tgl_input`, `user_input`, `id_pembelian`, `tgl_pembelian`, `id_supplier`, `no_bon`, `tgl_TOP`, `gambar`, `diskon`, `keterangan`) VALUES
('2019-11-16 23:57:03', 'a000000000', 'b000000001', '2019-11-08', 'p000000001', 'bon1', '2019-12-08', '', '0', ''),
('2019-11-17 00:07:50', 'a000000000', 'b000000005', '2019-11-06', 'p000000001', 'bon2', '2020-02-04', '', '10%', '');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_penjualan` varchar(255) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `id_customer` varchar(255) NOT NULL,
  `id_sales` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`tgl_input`, `user_input`, `id_penjualan`, `tgl_penjualan`, `id_customer`, `id_sales`, `tgl_TOP`, `diskon`, `keterangan`) VALUES
('2019-11-17 00:11:26', 'a000000000', 'j000000001', '2019-11-13', 'p000000002', 'p000000003', '2020-01-12', '10%', '');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id_person` varchar(10) NOT NULL,
  `nama_person` varchar(255) NOT NULL,
  `jenis` text NOT NULL,
  `notlpn` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id_person`, `nama_person`, `jenis`, `notlpn`, `alamat`, `npwp`, `gambar`) VALUES
('p000000001', 'supplier1', 'supplier', '', '', '', ''),
('p000000002', 'customer1', 'customer', '', '', '', ''),
('p000000003', 'sales1', 'sales', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli`
--

CREATE TABLE `retur_beli` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_retur_beli` varchar(255) NOT NULL,
  `tgl_retur_beli` date NOT NULL,
  `id_supplier` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `retur_jual`
--

CREATE TABLE `retur_jual` (
  `tgl_input` datetime NOT NULL,
  `user_input` varchar(255) NOT NULL,
  `id_retur_jual` varchar(255) NOT NULL,
  `tgl_retur_jual` date NOT NULL,
  `id_customer` varchar(255) NOT NULL,
  `tgl_TOP` date NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id_person` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id_person`, `nominal`, `flag`) VALUES
('p000000001', 5000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `tgl_input` datetime NOT NULL,
  `id_item` varchar(10) NOT NULL,
  `stock_awal` decimal(7,2) DEFAULT NULL,
  `stock_sisa` decimal(7,2) DEFAULT NULL,
  `batch` varchar(12) NOT NULL,
  `gudang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`tgl_input`, `id_item`, `stock_awal`, `stock_sisa`, `batch`, `gudang`) VALUES
('2019-11-16 23:57:03', 'i000000001', 10.00, 8.00, '900000000001', 'G000000001'),
('2019-11-17 00:07:50', 'i000000003', 5.00, 5.00, '900000000006', 'G000000001');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(40) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_alamat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_nama`, `user_email`, `user_alamat`) VALUES
(1, 'User ke-1', 'email@gmail.com', 'Alamat ke-1'),
(2, 'User ke-2', 'email@gmail.com', 'Alamat ke-2'),
(3, 'User ke-3', 'email@gmail.com', 'Alamat ke-3'),
(4, 'User ke-4', 'email@gmail.com', 'Alamat ke-4'),
(5, 'User ke-5', 'email@gmail.com', 'Alamat ke-5'),
(6, 'User ke-6', 'email@gmail.com', 'Alamat ke-6'),
(7, 'User ke-7', 'email@gmail.com', 'Alamat ke-7'),
(8, 'User ke-8', 'email@gmail.com', 'Alamat ke-8'),
(9, 'User ke-9', 'email@gmail.com', 'Alamat ke-9'),
(10, 'User ke-10', 'email@gmail.com', 'Alamat ke-10'),
(11, 'User ke-11', 'email@gmail.com', 'Alamat ke-11'),
(12, 'User ke-12', 'email@gmail.com', 'Alamat ke-12'),
(13, 'User ke-13', 'email@gmail.com', 'Alamat ke-13'),
(14, 'User ke-14', 'email@gmail.com', 'Alamat ke-14'),
(15, 'User ke-15', 'email@gmail.com', 'Alamat ke-15');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
