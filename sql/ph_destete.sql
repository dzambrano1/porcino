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
-- Table structure for table `ph_destete`
--

CREATE TABLE `ph_destete` (
  `id` int(11) NOT NULL,
  `ph_destete_tagid` varchar(10) NOT NULL,
  `ph_destete_peso` decimal(10,2) NOT NULL,
  `ph_destete_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_destete`
--

INSERT INTO `ph_destete` (`id`, `ph_destete_tagid`, `ph_destete_peso`, `ph_destete_fecha`) VALUES
(1, '3000', 250.00, '2025-01-12'),
(2, '3000', 100.00, '2025-01-13'),
(3, '5000', 200.00, '2024-11-01'),
(4, '20000', 200.00, '2024-11-01'),
(5, '8210', 200.00, '2024-11-01'),
(6, '27500', 250.00, '2024-11-01'),
(7, '24200', 210.00, '2024-11-01'),
(8, '45000', 200.00, '2024-11-01'),
(9, '599', 210.00, '2024-11-01'),
(10, '3000', 300.00, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_destete`
--
ALTER TABLE `ph_destete`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_destete`
--
ALTER TABLE `ph_destete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
