-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2026 at 12:05 PM
-- Server version: 8.0.30
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safecampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'medan kolej uitm jasin, melaka', 'clinic', 3.5951956000000003, 98.6722227, '2026-01-26 17:49:48', NULL),
(2, 'uitm segamat', 'Building', 2.4879644, 102.7293026, '2026-01-26 17:49:48', NULL),
(3, 'uitm dungun', 'security', 4.7035488, 103.4409542, '2026-01-26 17:49:48', NULL),
(4, 'pantai klebang', 'clinic', 2.2163849, 102.1925005, '2026-01-26 17:49:48', NULL),
(5, 'hospital melaka', 'clinic', 2.2172348, 102.26133499999999, '2026-01-26 17:49:48', NULL),
(6, 'uitm jasin', 'security', 2.2213407, 102.45310149999999, '2026-01-26 17:49:48', NULL),
(7, 'mitc', 'security', 2.27102, 102.2876399, '2026-01-26 17:49:48', NULL),
(8, 'mrsm tun ghafar baba', 'security', 2.3019675, 102.44055910000002, '2026-01-26 17:49:48', NULL),
(9, 'surau uitm', 'Emergency', 2.2213407, 102.45310149999999, '2026-02-05 08:47:46', '2026-02-05 16:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `username`, `email`, `phone`, `password`, `birthdate`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'NUR ANIS SYAFIKA', 'syaanis_', 'anissyafika824@gmail.com', '0123699686', '$2y$10$swVTBbtEaI6J5cNt7o1lr.ncECqa4j23UcqIc.ejZDx6L.yC103Ui', '2004-02-08', 'Female', '2026-01-26 17:50:41', '2026-02-05 09:36:01'),
(2, 'WAN SHAH', 'wnshah_', 'wnshah16@gmail.com', '0199823657', '$2y$10$vqiZ1MCoEFBiv8FFj9WmYuft.SN6SqoP0UQYzwWr1m/S2pU6QKlSC', '2004-02-16', 'Male', '2026-01-26 17:50:41', NULL),
(3, 'NUR DAHLIA', 'dahliaa_', 'dahliaa222@gmail.com', '0112569809', '$2y$10$/ruT/wR85q/U9M/43BK0zOnmmRiArrKgOvVCPCAl8xBErNysSdAQ.', '2002-02-02', 'Female', '2026-01-26 17:50:41', NULL),
(4, 'NORSHAMIERA', 'mierashax_', 'miera92@gmail.com', '0128960934', '$2y$10$OMMLHufh0RzEMj5CKhWqleAur9bmCuePXcT5wH5LoGamjuv1eiMje', '1992-10-20', 'Female', '2026-01-26 17:50:41', NULL),
(5, 'RAUDHAH NOOR', 'raudhah_', 'raudhahnoor23@gmail.com', '0199878767', '$2y$10$S9VtDkWIyGd.ME2y3SLiTO0uUmonYZIkg2VcF8BUjrVkPepLNLqOu', '1990-10-21', 'Female', '2026-01-26 17:50:41', NULL),
(6, 'AMIRUL FARIS', 'fariss_', 'farisamirul27_', '0190876546', '$2y$10$liXrQu38WRuco4lyrjxauu2MvunDxF2a6wKoPCzVZHLtULwJ/BS6a', '2001-03-27', 'Male', '2026-01-26 17:50:41', NULL),
(7, 'MUHAMMAD AIMAN', 'aiman_', 'aiman29@gmail.com', '0112680921', '$2y$10$uHMZhgCYzifGwIF3Mm.PkuHD57Kufjlyw.yBzk4Pa7TzN8vYauUg6', '2000-01-29', 'Male', '2026-01-26 17:50:41', NULL),
(8, 'RAISYAH', 'raisyah_', 'raisyahs_', '0120989987', '$2y$10$7RqPrRGqGfQqwLFcPv5ME.BvCUt81h7ezWqvTZhLtN92OpzkIIJO.', '2010-01-25', 'Female', '2026-01-26 17:50:41', NULL),
(10, 'ASH', 'ash_', 'ash@gmail.com', '0112357629', '$2y$10$lVDqXvhTxTQTHUrOqAldOO//ABlDwQFznX9ysYHVN8I.EB9lTSO2u', '2026-01-12', 'Male', '2026-01-26 17:50:41', NULL),
(12, 'NUR AEESY', 'ac.aessy_', 'ac@gmail.com', '0199876789', '$2y$10$OWCeC3Objvz05TXhXR/./ONhjV7OgRZBp.9/KrnkMlrwSnxh3q2eu', '2003-03-11', 'Female', '2026-01-26 17:50:41', NULL),
(13, 'NUR KAMELIA', 'cameliaa_', 'kamelia04@gmail.com', '0198970966', '$2y$10$9OP6NL4FeCR7RPwxi9NU1ex5SwvXdqpqSNxdOC49OOCnqndcgybYS', '2000-12-04', 'Female', '2026-02-05 13:44:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `incident_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `timestamp` timestamp NOT NULL,
  `status` enum('Pending','In Progress','Resolved','Unresolved') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `username`, `incident_type`, `description`, `location`, `latitude`, `longitude`, `timestamp`, `status`, `updated_at`) VALUES
(2, 'syaanis_', 'Crime', 'samun', 'medan kolej uitm jasin, melaka', 3.5951956000000003, 98.6722227, '2026-01-25 18:43:01', 'Unresolved', '2026-02-05 15:04:20'),
(3, 'syaanis_', 'Accident', 'moto terbabas langgar tiang lampu', 'uitm segamat', 2.4879644, 102.7293026, '2026-01-25 18:43:13', 'Pending', '2026-02-05 18:44:01'),
(4, 'mierashax_', 'Damaged', 'blackout', 'uitm dungun', 4.7035488, 103.4409542, '2026-01-25 18:43:30', 'Pending', '2026-02-05 18:43:47'),
(5, 'wnshah_', 'Crime', 'penculikan budak 4 tahun perempuan', 'pantai klebang', 2.2163849, 102.1925005, '2026-01-25 18:43:48', 'In Progress', '2026-02-05 18:43:22'),
(6, 'dahliaa_', 'Crime', 'lumba motor', 'hospital melaka', 2.2172348, 102.26133499999999, '2026-01-25 18:44:02', 'In Progress', '2026-02-05 15:04:20'),
(7, 'mierashax_', 'Damaged', 'paip pecah', 'uitm jasin', 2.2213407, 102.45310149999999, '2026-01-25 18:44:16', 'Resolved', '2026-02-05 18:24:58'),
(8, 'ash_', 'Damaged', 'pecah masuk kedai', 'mitc', 2.27102, 102.2876399, '2026-01-25 10:40:07', 'Unresolved', '2026-02-05 15:04:20'),
(9, 'abdrahman_', 'Crime', 'buli', 'mrsm tun ghafar baba', 2.3019675, 102.44055910000002, '2026-01-25 11:10:21', 'Unresolved', '2026-02-05 15:04:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
