-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:26 PM
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
-- Table structure for table `pc_mastitis`
--

CREATE TABLE `pc_mastitis` (
  `id` int(11) NOT NULL,
  `pc_mastitis_vacuna` varchar(30) NOT NULL,
  `pc_mastitis_dosis` decimal(10,2) NOT NULL,
  `pc_mastitis_costo` decimal(10,2) NOT NULL,
  `pc_mastitis_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_mastitis`
--

INSERT INTO `pc_mastitis` (`id`, `pc_mastitis_vacuna`, `pc_mastitis_dosis`, `pc_mastitis_costo`, `pc_mastitis_vigencia`) VALUES
(1, 'Mastilac', 1.53, 2.35, 180),
(3, 'Engemycin® L.A', 0.30, 0.88, 180),
(4, 'Ubrolex', 0.50, 1.50, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_mastitis`
--
ALTER TABLE `pc_mastitis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_mastitis`
--
ALTER TABLE `pc_mastitis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
