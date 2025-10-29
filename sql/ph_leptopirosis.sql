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
-- Table structure for table `ph_leptopirosis`
--

CREATE TABLE `ph_leptopirosis` (
  `id` int(11) NOT NULL,
  `ph_leptopirosis_tagid` varchar(10) NOT NULL,
  `ph_leptopirosis_producto` varchar(50) NOT NULL,
  `ph_leptopirosis_dosis` decimal(10,2) NOT NULL,
  `ph_leptopirosis_costo` decimal(10,2) NOT NULL,
  `ph_leptopirosis_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_leptopirosis`
--

INSERT INTO `ph_leptopirosis` (`id`, `ph_leptopirosis_tagid`, `ph_leptopirosis_producto`, `ph_leptopirosis_dosis`, `ph_leptopirosis_costo`, `ph_leptopirosis_fecha`) VALUES
(5, '101', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(6, '102', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(7, '103', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(8, '104', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(9, '105', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(10, '21241', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(11, '2125', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(12, '214', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(13, '23211', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(14, '23777', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(15, '252', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(16, '25422', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(17, '36242', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(18, '45242', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(19, '52526', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(20, '63211', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(21, '63522', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(22, '6625', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(23, '74512', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(24, '754', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(25, '75422', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(26, '7575', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(27, '93688', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(28, '9898', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
(29, '101', 'Nobivac Lepto', 1.00, 0.50, '2025-01-01'),
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
-- Indexes for table `ph_leptopirosis`
--
ALTER TABLE `ph_leptopirosis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_leptopirosis`
--
ALTER TABLE `ph_leptopirosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
