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
-- Table structure for table `pc_coccidiosis`
--

CREATE TABLE `pc_coccidiosis` (
  `id` int(11) NOT NULL,
  `pc_coccidiosis_vacuna` varchar(30) NOT NULL,
  `pc_coccidiosis_dosis` decimal(10,2) NOT NULL,
  `pc_coccidiosis_costo` decimal(10,2) NOT NULL,
  `pc_coccidiosis_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_coccidiosis`
--

INSERT INTO `pc_coccidiosis` (`id`, `pc_coccidiosis_vacuna`, `pc_coccidiosis_dosis`, `pc_coccidiosis_costo`, `pc_coccidiosis_vigencia`) VALUES
(1, 'COCCIVAC® -D2', 2.00, 1.20, 180),
(3, 'BAYCOX5% (TOLTRAZURIL)', 2.00, 1.50, 180),
(4, 'CALBOCOX\n', 2.00, 1.60, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_coccidiosis`
--
ALTER TABLE `pc_coccidiosis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_coccidiosis`
--
ALTER TABLE `pc_coccidiosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
