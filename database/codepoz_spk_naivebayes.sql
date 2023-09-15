-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2023 at 07:54 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codepoz_spk_naivebayes`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_alternatif`
--

CREATE TABLE `tb_alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_alternatif`
--

INSERT INTO `tb_alternatif` (`id_alternatif`, `nama`) VALUES
(1, 'Tidak'),
(2, 'Minat');

-- --------------------------------------------------------

--
-- Table structure for table `tb_evaluasi`
--

CREATE TABLE `tb_evaluasi` (
  `id_evaluasi` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `count` int(11) DEFAULT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_evaluasi`
--

INSERT INTO `tb_evaluasi` (`id_evaluasi`, `id_alternatif`, `id_kriteria`, `count`, `nilai`) VALUES
(1, 1, 1, 0, 1),
(2, 1, 2, 0, 1),
(3, 1, 3, 0, 1),
(4, 1, 1, 2, 1),
(5, 1, 2, 2, 2),
(6, 1, 3, 2, 1),
(7, 1, 1, 3, 2),
(8, 1, 2, 3, 2),
(9, 1, 3, 3, 1),
(10, 1, 1, 4, 1),
(11, 1, 2, 4, 2),
(12, 1, 3, 4, 1),
(13, 2, 1, 0, 1),
(14, 2, 2, 0, 2),
(15, 2, 3, 0, 1),
(16, 1, 1, 5, 1),
(17, 1, 2, 5, 2),
(18, 1, 3, 5, 2),
(19, 2, 1, 2, 1),
(20, 2, 2, 2, 2),
(21, 2, 3, 2, 2),
(22, 1, 1, 6, 1),
(23, 1, 2, 6, 2),
(24, 1, 3, 6, 3),
(25, 1, 1, 7, 2),
(26, 1, 2, 7, 2),
(27, 1, 3, 7, 3),
(28, 2, 1, 3, 2),
(29, 2, 2, 3, 2),
(30, 2, 3, 3, 3),
(31, 2, 1, 4, 1),
(32, 2, 2, 4, 2),
(33, 2, 3, 4, 1),
(34, 2, 1, 5, 1),
(35, 2, 2, 5, 1),
(36, 2, 3, 5, 1),
(37, 2, 1, 6, 1),
(38, 2, 2, 6, 2),
(39, 2, 3, 6, 1),
(40, 2, 1, 7, 2),
(41, 2, 2, 7, 2),
(42, 2, 3, 7, 1),
(43, 2, 1, 8, 1),
(44, 2, 2, 8, 3),
(45, 2, 3, 8, 1),
(46, 2, 1, 9, 1),
(47, 2, 2, 9, 3),
(48, 2, 3, 9, 2),
(49, 1, 1, 8, 1),
(50, 1, 2, 8, 3),
(51, 1, 3, 8, 1),
(52, 2, 1, 10, 1),
(53, 2, 2, 10, 2),
(54, 2, 3, 10, 1),
(55, 2, 1, 11, 1),
(56, 2, 2, 11, 2),
(57, 2, 3, 11, 1),
(58, 1, 1, 9, 1),
(59, 1, 2, 9, 1),
(60, 1, 3, 9, 3),
(61, 2, 1, 12, 1),
(62, 2, 2, 12, 3),
(63, 2, 3, 12, 2),
(64, 1, 1, 10, 1),
(65, 1, 2, 10, 3),
(66, 1, 3, 10, 3),
(67, 1, 1, 11, 1),
(68, 1, 2, 11, 1),
(69, 1, 3, 11, 1),
(70, 2, 1, 13, 2),
(71, 2, 2, 13, 3),
(72, 2, 3, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`id_kriteria`, `nama`) VALUES
(1, 'Kuota'),
(2, 'Masa Aktif'),
(3, 'Harga');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria_sub`
--

CREATE TABLE `tb_kriteria_sub` (
  `id_kriteria_sub` int(11) NOT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kriteria_sub`
--

INSERT INTO `tb_kriteria_sub` (`id_kriteria_sub`, `id_kriteria`, `nama`, `nilai`) VALUES
(1, 1, 'Dibawah 7GB', 1),
(2, 1, 'Diatas 7GB', 2),
(3, 2, '1 Minggu', 1),
(4, 2, '1 Bulan', 2),
(5, 2, '6 Bulan', 3),
(6, 3, 'Rendah', 1),
(7, 3, 'Sedang', 2),
(8, 3, 'Tinggi', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `id_member` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tmp_lahir` varchar(50) DEFAULT NULL,
  `kelamin` enum('L','P') DEFAULT NULL,
  `telepon` varchar(13) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`id_member`, `id_users`, `tgl_lahir`, `tmp_lahir`, `kelamin`, `telepon`, `alamat`) VALUES
(1, 54979492, '2023-03-10', 'gowa', 'L', '123123', 'gowa');

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat`
--

CREATE TABLE `tb_riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `hasil` json DEFAULT NULL,
  `tgl` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_users` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `token` text,
  `tokenExpire` text,
  `level` enum('admin','users') DEFAULT NULL,
  `status` enum('0','1') NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_users`, `nama`, `email`, `username`, `password`, `picture`, `token`, `tokenExpire`, `level`, `status`, `created`, `modified`) VALUES
(1, 'Alan Saputra Lengkoan', 'alanlengkoan15@gmail.com', 'admin', '$2y$10$CR9Pd9ALwRZ4J610leCea.1S6QNrv6aYARP9zp7TdvMNNyz.ZVCc6', NULL, 'SMVyGX4vuat9fBAgRxJ3Kh6lYQqbCD1E', '1578184269', 'admin', '1', '2020-01-02 05:23:40', '2023-02-19 13:22:36'),
(54979492, 'alan', 'alan@gmail.com', 'alan', '$2y$10$LauXL9Njx38qGBXyOm5oDuLzhU0.vHSMyUupBY3Kjx0QL0jqTxdf6', NULL, NULL, NULL, 'users', '1', '2023-03-10 03:02:47', '2023-03-10 03:02:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `tb_evaluasi`
--
ALTER TABLE `tb_evaluasi`
  ADD PRIMARY KEY (`id_evaluasi`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_alternatif` (`id_alternatif`);

--
-- Indexes for table `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `tb_kriteria_sub`
--
ALTER TABLE `tb_kriteria_sub`
  ADD PRIMARY KEY (`id_kriteria_sub`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id_member`),
  ADD KEY `member_to_users` (`id_users`);

--
-- Indexes for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_evaluasi`
--
ALTER TABLE `tb_evaluasi`
  MODIFY `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_kriteria_sub`
--
ALTER TABLE `tb_kriteria_sub`
  MODIFY `id_kriteria_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54979493;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_evaluasi`
--
ALTER TABLE `tb_evaluasi`
  ADD CONSTRAINT `evaluasi_to_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `tb_alternatif` (`id_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluasi_to_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `tb_kriteria` (`id_kriteria`) ON DELETE CASCADE;

--
-- Constraints for table `tb_kriteria_sub`
--
ALTER TABLE `tb_kriteria_sub`
  ADD CONSTRAINT `sub_kriteria_to_kritera` FOREIGN KEY (`id_kriteria`) REFERENCES `tb_kriteria` (`id_kriteria`) ON DELETE CASCADE;

--
-- Constraints for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD CONSTRAINT `member_to_users` FOREIGN KEY (`id_users`) REFERENCES `tb_users` (`id_users`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
