-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:39 PM
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
-- Table structure for table `ph_venta`
--

CREATE TABLE `ph_venta` (
  `id` int(11) NOT NULL,
  `ph_venta_tagid` varchar(10) NOT NULL,
  `ph_venta_peso` decimal(10,2) NOT NULL,
  `ph_venta_precio` decimal(10,2) NOT NULL,
  `ph_venta_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_venta`
--

INSERT INTO `ph_venta` (`id`, `ph_venta_tagid`, `ph_venta_peso`, `ph_venta_precio`, `ph_venta_fecha`) VALUES
(1, '3000', 250.00, 4.00, '2025-02-01'),
(2, '3000', 100.00, 4.00, '2025-02-01'),
(6, '3000', 500.00, 4.20, '2025-02-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_venta`
--
ALTER TABLE `ph_venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_venta`
--
ALTER TABLE `ph_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
