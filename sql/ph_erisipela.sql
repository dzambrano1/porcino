-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:35 PM
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
-- Table structure for table `ph_erisipela`
--

CREATE TABLE `ph_erisipela` (
  `id` int(11) NOT NULL,
  `ph_erisipela_tagid` varchar(10) NOT NULL,
  `ph_erisipela_producto` varchar(50) NOT NULL,
  `ph_erisipela_dosis` decimal(10,2) NOT NULL,
  `ph_erisipela_costo` decimal(10,2) NOT NULL,
  `ph_erisipela_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_erisipela`
--

INSERT INTO `ph_erisipela` (`id`, `ph_erisipela_tagid`, `ph_erisipela_producto`, `ph_erisipela_dosis`, `ph_erisipela_costo`, `ph_erisipela_fecha`) VALUES
(1, '3000', 'Porcilis', 2.00, 1.30, '2023-01-05'),
(2, '102', 'Porcilis', 2.00, 1.30, '2024-01-06'),
(3, '105', 'Porcilis', 2.00, 1.30, '2025-01-07'),
(4, '21241', 'Porcilis', 2.00, 1.30, '2025-01-16'),
(5, '2125', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(6, '214', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(7, '23211', 'Porcilis', 2.00, 1.30, '2025-01-07'),
(8, '23777', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(9, '252', 'Porcilis', 2.00, 1.30, '2025-01-07'),
(10, '25422', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(11, '36242', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(12, '45242', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(13, '36242', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(14, '52526', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(15, '63211', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(16, '63522', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(17, '6625', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(18, '74512', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(19, '7575', 'Porcilis', 2.00, 1.30, '2023-01-05'),
(20, '93688', 'Porcilis', 2.00, 1.30, '2025-01-07'),
(21, '9898', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(22, '101', 'Porcilis', 2.00, 1.30, '2025-01-07'),
(23, '103', 'Porcilis', 2.00, 1.30, '2025-01-07'),
(24, '121', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(25, '21522', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(26, '24993', 'Porcilis', 2.00, 1.30, '2025-01-21'),
(27, '65422', 'Porcilis', 2.00, 1.30, '2023-01-05'),
(28, '85221', 'Porcilis', 2.00, 1.30, '2024-01-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_erisipela`
--
ALTER TABLE `ph_erisipela`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_erisipela`
--
ALTER TABLE `ph_erisipela`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
