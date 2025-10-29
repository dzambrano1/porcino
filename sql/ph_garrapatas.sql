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
-- Table structure for table `ph_garrapatas`
--

CREATE TABLE `ph_garrapatas` (
  `id` int(11) NOT NULL,
  `ph_garrapatas_tagid` varchar(10) NOT NULL,
  `ph_garrapatas_producto` varchar(50) NOT NULL,
  `ph_garrapatas_dosis` decimal(10,2) NOT NULL,
  `ph_garrapatas_costo` decimal(10,2) NOT NULL,
  `ph_garrapatas_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_garrapatas`
--

INSERT INTO `ph_garrapatas` (`id`, `ph_garrapatas_tagid`, `ph_garrapatas_producto`, `ph_garrapatas_dosis`, `ph_garrapatas_costo`, `ph_garrapatas_fecha`) VALUES
(1, '3000', 'Garrapatas 1', 0.80, 10.40, '2023-01-05'),
(2, '3000', 'Garrapatas 2', 0.85, 11.50, '2024-01-06'),
(3, '3000', 'Garrapatas 3', 0.90, 12.60, '2025-01-07'),
(4, '3000', 'Garrapatas 1', 0.90, 10.40, '2025-01-07'),
(5, '3000', 'Garrapatas 3', 0.90, 12.60, '2025-01-16'),
(7, '3000', 'Garrapatas 1', 0.80, 10.40, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_garrapatas`
--
ALTER TABLE `ph_garrapatas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_garrapatas`
--
ALTER TABLE `ph_garrapatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
