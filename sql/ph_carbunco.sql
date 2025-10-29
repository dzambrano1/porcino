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
-- Table structure for table `ph_carbunco`
--

CREATE TABLE `ph_carbunco` (
  `id` int(11) NOT NULL,
  `ph_carbunco_tagid` varchar(10) NOT NULL,
  `ph_carbunco_producto` varchar(50) NOT NULL,
  `ph_carbunco_dosis` decimal(10,2) NOT NULL,
  `ph_carbunco_costo` decimal(10,2) NOT NULL,
  `ph_carbunco_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_carbunco`
--

INSERT INTO `ph_carbunco` (`id`, `ph_carbunco_tagid`, `ph_carbunco_producto`, `ph_carbunco_dosis`, `ph_carbunco_costo`, `ph_carbunco_fecha`) VALUES
(1, '3000', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(2, '101', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(3, '102', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(4, '103', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(5, '105', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(6, '21241', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(7, '2125', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(8, '214', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(9, '23211', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(10, '23777', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(11, '252', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(12, '25422', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(13, '36242', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(14, '45242', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(15, '52526', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(16, '63211', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(17, '63522', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(18, '6625', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(19, '74512', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(20, '754', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(21, '75422', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(22, '7575', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(23, '93688', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(24, '9898', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(25, '101', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(26, '103', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(27, '121', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(28, '21522', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(29, '24993', 'Rayovacuna', 1.00, 0.10, '2023-01-05'),
(30, '2542', 'Rayovacuna', 1.00, 0.10, '2024-01-06'),
(31, '3000', 'Rayovacuna', 1.00, 0.10, '2025-01-07'),
(32, '65422', 'Rayovacuna', 1.00, 0.10, '2025-01-21'),
(33, '85221', 'Rayovacuna', 1.00, 0.10, '2023-01-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_carbunco`
--
ALTER TABLE `ph_carbunco`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_carbunco`
--
ALTER TABLE `ph_carbunco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
