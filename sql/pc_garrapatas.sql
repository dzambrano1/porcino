-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:24 PM
-- Server version: 10.6.22-MariaDB-cll-lve
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ganagram`
--

-- --------------------------------------------------------

--
-- Table structure for table `pc_garrapatas`
--

CREATE TABLE `pc_garrapatas` (
  `id` int(11) NOT NULL,
  `pc_garrapatas_vacuna` varchar(30) NOT NULL,
  `pc_garrapatas_dosis` decimal(10,2) NOT NULL,
  `pc_garrapatas_costo` decimal(10,2) NOT NULL,
  `pc_garrapatas_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_garrapatas`
--

INSERT INTO `pc_garrapatas` (`id`, `pc_garrapatas_vacuna`, `pc_garrapatas_dosis`, `pc_garrapatas_costo`, `pc_garrapatas_vigencia`) VALUES
(1, 'FIPROK', 2.00, 0.50, 180),
(3, 'SUPRALINE', 0.30, 0.88, 180),
(4, 'IVERGAN', 0.50, 1.50, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_garrapatas`
--
ALTER TABLE `pc_garrapatas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_garrapatas`
--
ALTER TABLE `pc_garrapatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
