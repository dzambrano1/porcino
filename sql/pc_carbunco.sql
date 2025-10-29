-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:23 PM
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
-- Table structure for table `pc_carbunco`
--

CREATE TABLE `pc_carbunco` (
  `id` int(11) NOT NULL,
  `pc_carbunco_vacuna` varchar(30) NOT NULL,
  `pc_carbunco_dosis` decimal(10,2) NOT NULL,
  `pc_carbunco_costo` decimal(10,2) NOT NULL,
  `pc_carbunco_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_carbunco`
--

INSERT INTO `pc_carbunco` (`id`, `pc_carbunco_vacuna`, `pc_carbunco_dosis`, `pc_carbunco_costo`, `pc_carbunco_vigencia`) VALUES
(1, 'Carbunco Forte', 1.53, 2.35, 180),
(3, 'Farbiovac', 0.30, 0.88, 180),
(4, 'Carbunclo', 0.50, 1.50, 180),
(5, 'Vac-sules', 0.50, 1.50, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_carbunco`
--
ALTER TABLE `pc_carbunco`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_carbunco`
--
ALTER TABLE `pc_carbunco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
