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
-- Table structure for table `ph_mal_rojo`
--

CREATE TABLE `ph_mal_rojo` (
  `id` int(11) NOT NULL,
  `ph_mal_rojo_tagid` varchar(10) NOT NULL,
  `ph_mal_rojo_producto` varchar(50) NOT NULL,
  `ph_mal_rojo_dosis` decimal(10,2) NOT NULL,
  `ph_mal_rojo_costo` decimal(10,2) NOT NULL,
  `ph_mal_rojo_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_mal_rojo`
--

INSERT INTO `ph_mal_rojo` (`id`, `ph_mal_rojo_tagid`, `ph_mal_rojo_producto`, `ph_mal_rojo_dosis`, `ph_mal_rojo_costo`, `ph_mal_rojo_fecha`) VALUES
(1, '3000', 'Mal Rojo 1', 2.10, 10.40, '2023-01-05'),
(2, '3000', 'Mal Rojo 2', 2.15, 11.50, '2024-01-06'),
(3, '3000', 'Mal Rojo 3', 2.99, 12.60, '2025-01-07'),
(4, '3000', 'Mal Rojo 3', 2.10, 11.50, '2025-01-16'),
(5, '3000', 'Mal Rojo 1', 2.99, 12.60, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_mal_rojo`
--
ALTER TABLE `ph_mal_rojo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_mal_rojo`
--
ALTER TABLE `ph_mal_rojo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
