-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:27 PM
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
-- Table structure for table `pc_peste`
--

CREATE TABLE `pc_peste` (
  `id` int(11) NOT NULL,
  `pc_peste_vacuna` varchar(30) NOT NULL,
  `pc_peste_dosis` decimal(10,2) NOT NULL,
  `pc_peste_costo` decimal(10,2) NOT NULL,
  `pc_peste_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_peste`
--

INSERT INTO `pc_peste` (`id`, `pc_peste_vacuna`, `pc_peste_dosis`, `pc_peste_costo`, `pc_peste_vigencia`) VALUES
(1, 'AdvaVac', 2.00, 0.20, 180),
(3, 'Porvac', 0.30, 0.88, 180),
(5, 'Pestiffa', 2.00, 0.25, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_peste`
--
ALTER TABLE `pc_peste`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_peste`
--
ALTER TABLE `pc_peste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
