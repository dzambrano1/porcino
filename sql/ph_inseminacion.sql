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
-- Table structure for table `ph_inseminacion`
--

CREATE TABLE `ph_inseminacion` (
  `id` int(11) NOT NULL,
  `ph_inseminacion_tagid` varchar(10) NOT NULL,
  `ph_inseminacion_numero` int(10) NOT NULL,
  `ph_inseminacion_costo` decimal(10,2) NOT NULL,
  `ph_inseminacion_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_inseminacion`
--

INSERT INTO `ph_inseminacion` (`id`, `ph_inseminacion_tagid`, `ph_inseminacion_numero`, `ph_inseminacion_costo`, `ph_inseminacion_fecha`) VALUES
(1, '3000', 1, 9.00, '2023-01-01'),
(2, '3000', 2, 10.00, '2024-01-01'),
(3, '3000', 3, 11.00, '2025-01-01'),
(4, '3000', 4, 20.00, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_inseminacion`
--
ALTER TABLE `ph_inseminacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_inseminacion`
--
ALTER TABLE `ph_inseminacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
