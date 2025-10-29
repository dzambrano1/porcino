-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:34 PM
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
-- Table structure for table `ph_coccidiosis`
--

CREATE TABLE `ph_coccidiosis` (
  `id` int(11) NOT NULL,
  `ph_coccidiosis_tagid` varchar(10) NOT NULL,
  `ph_coccidiosis_producto` varchar(50) NOT NULL,
  `ph_coccidiosis_dosis` decimal(10,2) NOT NULL,
  `ph_coccidiosis_costo` decimal(10,2) NOT NULL,
  `ph_coccidiosis_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_coccidiosis`
--

INSERT INTO `ph_coccidiosis` (`id`, `ph_coccidiosis_tagid`, `ph_coccidiosis_producto`, `ph_coccidiosis_dosis`, `ph_coccidiosis_costo`, `ph_coccidiosis_fecha`) VALUES
(8, '101', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(10, '102', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(11, '103', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(12, '105', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(13, '21241', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(14, '2125', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(15, '214', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(16, '23211', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(17, '23777', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(18, '252', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(19, '25422', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(20, '36242', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(21, '45242', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(22, '63211', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(23, '63522', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(25, '74512', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(26, '754', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(27, '75422', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(28, '7575', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(29, '93688', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(30, '9898', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(31, '121', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(32, '21522', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(33, '24993', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(34, '2542', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(35, '3000', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(36, '65422', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(37, '85221', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(38, '988777', 'Tratoril', 1.00, 0.05, '2025-01-01'),
(40, '6625', 'Tratoril', 1.00, 0.05, '2025-01-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_coccidiosis`
--
ALTER TABLE `ph_coccidiosis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_coccidiosis`
--
ALTER TABLE `ph_coccidiosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
