-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:38 PM
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
-- Table structure for table `ph_neumonia`
--

CREATE TABLE `ph_neumonia` (
  `id` int(11) NOT NULL,
  `ph_neumonia_tagid` varchar(10) NOT NULL,
  `ph_neumonia_producto` varchar(50) NOT NULL,
  `ph_neumonia_dosis` decimal(10,2) NOT NULL,
  `ph_neumonia_costo` decimal(10,2) NOT NULL,
  `ph_neumonia_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_neumonia`
--

INSERT INTO `ph_neumonia` (`id`, `ph_neumonia_tagid`, `ph_neumonia_producto`, `ph_neumonia_dosis`, `ph_neumonia_costo`, `ph_neumonia_fecha`) VALUES
(5, '101', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(6, '102', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(7, '103', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(8, '104', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(9, '105', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(10, '21241', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(11, '2125', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(12, '214', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(13, '23211', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(14, '23777', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(15, '252', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(16, '25422', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(17, '36242', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(18, '45242', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(19, '52526', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(20, '63211', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(21, '63522', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(22, '6625', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(23, '74512', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(24, '754', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(25, '75422', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(26, '7575', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(27, '93688', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(28, '9898', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(29, '101', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(30, '103', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(31, '121', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(32, '21522', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(33, '24993', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(34, '2542', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(35, '3000', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(36, '65422', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(37, '85221', 'Hyogen', 2.00, 0.50, '2025-01-01'),
(38, '988777', 'Hyogen', 2.00, 0.50, '2025-01-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_neumonia`
--
ALTER TABLE `ph_neumonia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_neumonia`
--
ALTER TABLE `ph_neumonia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
