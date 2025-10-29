-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:37 PM
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
-- Table structure for table `ph_lombrices`
--

CREATE TABLE `ph_lombrices` (
  `id` int(11) NOT NULL,
  `ph_lombrices_tagid` varchar(10) NOT NULL,
  `ph_lombrices_producto` varchar(50) NOT NULL,
  `ph_lombrices_dosis` decimal(10,2) NOT NULL,
  `ph_lombrices_costo` decimal(10,2) NOT NULL,
  `ph_lombrices_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_lombrices`
--

INSERT INTO `ph_lombrices` (`id`, `ph_lombrices_tagid`, `ph_lombrices_producto`, `ph_lombrices_dosis`, `ph_lombrices_costo`, `ph_lombrices_fecha`) VALUES
(1, '3000', 'Lombri I', 1.10, 5.10, '2025-01-06'),
(2, '3000', 'Lombri II', 1.15, 6.10, '2025-01-13'),
(3, '3000', 'Lombri III', 1.20, 7.50, '2025-01-12'),
(5, '3000', 'Lombri III', 1.10, 5.10, '2025-01-17'),
(6, '3000', 'Lombri I', 1.10, 5.10, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_lombrices`
--
ALTER TABLE `ph_lombrices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_lombrices`
--
ALTER TABLE `ph_lombrices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
