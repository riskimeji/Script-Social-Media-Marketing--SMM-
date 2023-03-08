-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 08, 2023 at 10:14 PM
-- Server version: 10.5.19-MariaDB-cll-lve-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mejixxmy_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `norek` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `jenis`, `nama`, `norek`) VALUES
(4, 'BANK BRI', 'Ahm', '546801006226500'),
(5, 'BANK BNI', 'asd', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `nama`) VALUES
(1, 'Instagram Likes'),
(34, 'Instagram Views'),
(35, 'Facebook Page Likes');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `bank_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jumlah_deposit` double NOT NULL,
  `total_didapat` double NOT NULL,
  `bukti_tf` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `date`, `bank_id`, `user_id`, `jumlah_deposit`, `total_didapat`, `bukti_tf`, `status`) VALUES
(20, '2023-01-31 10:37:03', 1, 11, 10000, 10000, 'cert-CT-MJDTGLGX.png', 'SUCCESS'),
(21, '2023-01-31 10:37:03', 1, 11, 10000, 10000, 'cert-CT-MJDTGLGX.png', 'SUCCESS'),
(22, '2023-02-04 15:16:12', 5, 13, 586585, 586585, 'Screenshot_2023-02-04-16-36-36-200_id.dana.jpg', 'DITOLAK'),
(23, '2023-02-05 06:48:13', 4, 18, 20000, 20000, 'bg.jpg', 'DITOLAK'),
(24, '2023-02-05 06:49:51', 4, 18, 10000, 10000, 'bg.jpg', 'SUCCESS'),
(25, '2023-02-11 12:02:17', 4, 21, 10000, 10000, 'Screenshot_20230211_101155.jpg', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `log_saldo`
--

CREATE TABLE `log_saldo` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `saldo_awal` double NOT NULL,
  `saldo_sisa` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_saldo`
--

INSERT INTO `log_saldo` (`id`, `date`, `nama`, `deskripsi`, `status`, `saldo_awal`, `saldo_sisa`) VALUES
(32, '2023-01-31 10:37:03', 'riskimeji', 'melakukan pemesanan Instagram likes (10/10k) [50-100/hour] [ No Refilll] [ Drop 40-50%]	', 'ORDER', 50859, 50000),
(33, '2023-01-31 10:51:48', 'riskimeji', 'melakukan pemesanan Instagram likes (10/10k) [50-100/hour] [ No Refilll] [ Drop 40-50%]	', 'ORDER', 50000, 49141),
(34, '2023-02-01 07:26:12', 'riskimeji', 'reffund saldo dari transaksi partial/error dengan id: 10', 'REFFUND', 49141, 50000),
(35, '2023-02-01 07:26:12', 'riskimeji', 'reffund saldo dari transaksi partial/error dengan id: 11', 'REFFUND', 50000, 50859),
(36, '2023-02-03 08:40:23', 'riskimeji', 'Melakukan Deposit dengan ID: 20', 'DEPOSIT MANUAL', 50859, 60859),
(37, '2023-02-03 08:41:37', 'riskimeji', 'Melakukan Deposit dengan ID: 21', 'DEPOSIT MANUAL', 60859, 70859),
(38, '2023-02-05 06:50:06', 'zulbano', 'Melakukan Deposit dengan ID: 24', 'DEPOSIT MANUAL', 0, 10000),
(39, '2023-02-05 06:51:05', 'zulbano', 'melakukan pemesanan Instagram likes (10/10k) [50-100/hour] [ No Refilll] [ Drop 40-50%]	', 'ORDER', 10000, 9141);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `user_id`, `date`, `kategori`, `deskripsi`) VALUES
(1, 12, '2023-02-03 09:04:35', 'INFO', 'test tuan'),
(3, 12, '2023-02-03 11:08:31', 'SERVICE', 'cek ');

-- --------------------------------------------------------

--
-- Table structure for table `orderd`
--

CREATE TABLE `orderd` (
  `order_id` int(11) NOT NULL,
  `id_layanan` int(20) NOT NULL,
  `date` datetime NOT NULL,
  `po_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `service_idp` int(20) NOT NULL,
  `jumlah_pesan` int(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `total_harga` double NOT NULL,
  `status` varchar(255) NOT NULL,
  `reffund` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderd`
--

INSERT INTO `orderd` (`order_id`, `id_layanan`, `date`, `po_id`, `user_id`, `service_idp`, `jumlah_pesan`, `target`, `total_harga`, `status`, `reffund`) VALUES
(10, 3, '2023-01-31 10:37:03', 13559033, 11, 8714, 1000, 'baka', 859, 'Processing', 1),
(11, 3, '2023-01-31 10:51:48', 13559046, 11, 8714, 1000, 'riasasd', 859, 'Processing', 1),
(12, 3, '2023-02-05 06:51:05', 13570836, 18, 8714, 1000, 'https://www.instagram.com/asdads/as', 859, 'Processing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `api_id` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`id`, `nama`, `api_id`, `api_key`) VALUES
(1, 'IRVANKEDE', '32245', '152bfe-cc2de1-bca80f-29bf51-ea3a68');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `category` int(20) NOT NULL,
  `p_id` int(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `min` int(20) NOT NULL,
  `max` int(20) NOT NULL,
  `est_masuk` text NOT NULL,
  `harga` int(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `category`, `p_id`, `nama`, `deskripsi`, `min`, `max`, `est_masuk`, `harga`, `status`) VALUES
(2, 34, 11509, 'Instagram views [ 300-500k/hour) [Works for REEL/IGTV/VIDEO]	', ' Instagram views [ 300-500k/hour) [Works for REEL/IGTV/VIDEO]	', 100, 100000, '09 Jam 11 Menit 32 Detik	  ', 287, 'aktif'),
(3, 1, 8714, 'Instagram likes (10/10k) [50-100/hour] [ No Refilll] [ Drop 40-50%]	', 'Instagram likes (10/10k) [50-100/hour] [ No Refilll] [ Drop 40-50%]', 10, 8590000, '02 Jam 16 Menit 23 Detik', 859, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(10) NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `phone`, `email`, `password`, `level`, `saldo`) VALUES
(11, 'demo', 'demo ', 'riskimeji', '081234567890', 'riskimeji6@gmail.com', '4823c694493f639645e824b1adfe4ba7', 'member', 70859),
(12, 'demo', 'demo ', 'ahmad', '081234567890', 'riskimeji7@gmail.com', '4823c694493f639645e824b1adfe4ba7', 'admin', 60859),
(13, 'demo', 'demo ', 'demo', '081234567890', 'demo@gmail.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 'member', 0),
(14, 'Meji', 'Coli', 'Mecol', '081239638521', 'mejol@gmail.com', 'db3a75d88c359e98953eb73d9c581085', 'member', 0),
(15, 'Secret', 'Person', 'Secret Per', '082231315696', 'secretperson@gmail.c', '68bdc8bdc0df85208e5f5edb03759ca6', 'member', 0),
(16, 'Kenapa', 'Salah', 'Kenapasala', '083213246316', 'kenapasalah@gmail.co', '2f3214fbade531a8e9880ad9a3759cba', 'member', 0),
(17, 'Akskks', 'akkask', 'asu', '08534646455', 'asu@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member', 0),
(18, 'Memex', 'rezki', 'zulbano', '0864376781845', 'merex@gmail.com', '4823c694493f639645e824b1adfe4ba7', 'member', 0),
(19, 'Udin', 'Jamali', 'Udinn', '08421386867', 'udin@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member', 0),
(20, 'ris', 'Is', 'riski', '08573494', 'riskikece1802@gmail.', 'dc9f2f43c0ccb088433944afaf5b2603', 'member', 0),
(21, 'zidan', 'zidane', 'zidann', '08123139123', 'zidann@gmail.com', 'dc9f2f43c0ccb088433944afaf5b2603', 'member', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_saldo`
--
ALTER TABLE `log_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderd`
--
ALTER TABLE `orderd`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relaticategory` (`category`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `log_saldo`
--
ALTER TABLE `log_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderd`
--
ALTER TABLE `orderd`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `relaticategory` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
