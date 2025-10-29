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
-- Table structure for table `ph_gestacion`
--

CREATE TABLE `ph_gestacion` (
  `id` int(11) NOT NULL,
  `ph_gestacion_tagid` varchar(10) NOT NULL,
  `ph_gestacion_numero` int(10) NOT NULL,
  `ph_gestacion_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_gestacion`
--

INSERT INTO `ph_gestacion` (`id`, `ph_gestacion_tagid`, `ph_gestacion_numero`, `ph_gestacion_fecha`) VALUES
(4, '3000', 1, '2023-01-10'),
(5, '3000', 2, '2024-01-13'),
(6, '3000', 3, '2024-10-25'),
(7, '3000', 4, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_gestacion`
--
ALTER TABLE `ph_gestacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_gestacion`
--
ALTER TABLE `ph_gestacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
