-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:33 PM
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
-- Table structure for table `ph_brucelosis`
--

CREATE TABLE `ph_brucelosis` (
  `id` int(11) NOT NULL,
  `ph_brucelosis_tagid` varchar(10) NOT NULL,
  `ph_brucelosis_producto` varchar(50) NOT NULL,
  `ph_brucelosis_dosis` decimal(10,2) NOT NULL,
  `ph_brucelosis_costo` decimal(10,2) NOT NULL,
  `ph_brucelosis_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_brucelosis`
--

INSERT INTO `ph_brucelosis` (`id`, `ph_brucelosis_tagid`, `ph_brucelosis_producto`, `ph_brucelosis_dosis`, `ph_brucelosis_costo`, `ph_brucelosis_fecha`) VALUES
(1, '3000', 'Brucelosis Adultos', 1.50, 10.40, '2023-01-05'),
(2, '3000', 'Brucelosis Inicio', 1.55, 11.50, '2024-01-06'),
(3, '3000', 'Brucelosis Inicio', 1.60, 12.60, '2025-01-07'),
(4, '3000', 'Brucelosis Adultos', 1.55, 10.40, '2025-01-07'),
(5, '3000', 'Brucelosis Adultos', 1.50, 10.40, '2025-01-21'),
(6, '101', 'Brucelosis Adultos', 1.00, 1.00, '2025-06-09'),
(7, '102', 'Brucelosis Adultos', 2.00, 1.99, '2025-06-09'),
(8, '103', 'Brucelosis Adultos', 3.00, 3.00, '2025-06-09'),
(9, '105', 'Brucelosis Adultos', 4.00, 3.00, '2025-06-09'),
(10, '121', 'Brucelosis Adultos', 3.00, 4.00, '2025-06-09'),
(11, '21241', 'Brucelosis Adultos', 4.00, 4.00, '2025-06-09'),
(12, '2125', 'Brucelosis Inicio', 4.00, 4.00, '2025-06-09'),
(13, '214', 'Brucelosis Novillos', 4.00, 3.00, '2025-06-09'),
(14, '21522', 'Brucelosis Adultos', 4.00, 4.00, '2025-06-09'),
(15, '23211', 'Brucelosis Adultos', 3.00, 3.00, '2025-06-09'),
(16, '23777', 'Brucelosis Adultos', 3.00, 4.00, '2025-06-09'),
(17, '24993', 'Brucelosis Adultos', 4.00, 4.00, '2025-06-09'),
(18, '252', 'Brucelosis Adultos', 4.00, 4.00, '2025-06-09'),
(19, '2542', 'Brucelosis Inicio', 4.00, 4.00, '2025-06-09'),
(20, '25422', 'Brucelosis Adultos', 3.00, 3.00, '2025-06-09'),
(21, '36242', 'Brucelosis Adultos', 4.00, 4.00, '2025-06-09'),
(22, '45242', 'Brucelosis Adultos', 3.00, 3.00, '2025-06-09'),
(23, '52526', 'Brucelosis Adultos', 2.00, 2.00, '2025-06-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_brucelosis`
--
ALTER TABLE `ph_brucelosis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_brucelosis`
--
ALTER TABLE `ph_brucelosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
