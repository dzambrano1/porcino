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
-- Table structure for table `ph_mastitis`
--

CREATE TABLE `ph_mastitis` (
  `id` int(11) NOT NULL,
  `ph_mastitis_tagid` varchar(10) NOT NULL,
  `ph_mastitis_producto` varchar(50) NOT NULL,
  `ph_mastitis_dosis` decimal(10,2) NOT NULL,
  `ph_mastitis_costo` decimal(10,2) NOT NULL,
  `ph_mastitis_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_mastitis`
--

INSERT INTO `ph_mastitis` (`id`, `ph_mastitis_tagid`, `ph_mastitis_producto`, `ph_mastitis_dosis`, `ph_mastitis_costo`, `ph_mastitis_fecha`) VALUES
(1, '3000', 'Mastitin', 2.40, 3.20, '2025-01-01'),
(2, '3000', 'Mastitin 2', 2.50, 3.50, '2025-01-13'),
(3, '3000', 'Mastitin 3', 2.70, 3.80, '2025-01-13'),
(4, '3000', 'Mastitin', 2.40, 3.20, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_mastitis`
--
ALTER TABLE `ph_mastitis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_mastitis`
--
ALTER TABLE `ph_mastitis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
