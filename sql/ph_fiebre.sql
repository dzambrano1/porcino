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
-- Table structure for table `ph_fiebre`
--

CREATE TABLE `ph_fiebre` (
  `id` int(11) NOT NULL,
  `ph_fiebre_tagid` varchar(10) NOT NULL,
  `ph_fiebre_producto` varchar(50) NOT NULL,
  `ph_fiebre_dosis` decimal(10,2) NOT NULL,
  `ph_fiebre_costo` decimal(10,2) NOT NULL,
  `ph_fiebre_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_fiebre`
--

INSERT INTO `ph_fiebre` (`id`, `ph_fiebre_tagid`, `ph_fiebre_producto`, `ph_fiebre_dosis`, `ph_fiebre_costo`, `ph_fiebre_fecha`) VALUES
(1, '3000', 'Fiebre II', 0.70, 10.40, '2023-01-05'),
(2, '3000', 'Fiebre I', 0.70, 11.50, '2024-01-06'),
(3, '3000', 'Fiebre III', 0.70, 12.60, '2024-12-07'),
(6, '3000', 'Fiebre IV', 0.80, 13.00, '2025-01-16'),
(7, '3000', 'Fiebre II', 0.70, 10.40, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_fiebre`
--
ALTER TABLE `ph_fiebre`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_fiebre`
--
ALTER TABLE `ph_fiebre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
