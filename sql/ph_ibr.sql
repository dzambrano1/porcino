-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:36 PM
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
-- Table structure for table `ph_ibr`
--

CREATE TABLE `ph_ibr` (
  `id` int(11) NOT NULL,
  `ph_ibr_tagid` varchar(10) NOT NULL,
  `ph_ibr_producto` varchar(50) NOT NULL,
  `ph_ibr_dosis` decimal(10,2) NOT NULL,
  `ph_ibr_costo` decimal(10,2) NOT NULL,
  `ph_ibr_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_ibr`
--

INSERT INTO `ph_ibr` (`id`, `ph_ibr_tagid`, `ph_ibr_producto`, `ph_ibr_dosis`, `ph_ibr_costo`, `ph_ibr_fecha`) VALUES
(1, '3000', 'IBR II', 0.70, 10.40, '2023-01-05'),
(2, '3000', 'IBR I', 0.70, 11.50, '2024-01-06'),
(3, '3000', 'IBR III', 0.70, 12.60, '2025-01-07'),
(4, '3000', 'IBR IV', 0.80, 13.00, '2025-01-16'),
(7, '3000', 'IBR II', 0.70, 10.40, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_ibr`
--
ALTER TABLE `ph_ibr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_ibr`
--
ALTER TABLE `ph_ibr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
