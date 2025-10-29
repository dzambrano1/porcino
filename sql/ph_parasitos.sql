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
-- Table structure for table `ph_parasitos`
--

CREATE TABLE `ph_parasitos` (
  `id` int(11) NOT NULL,
  `ph_parasitos_tagid` varchar(10) NOT NULL,
  `ph_parasitos_producto` varchar(50) NOT NULL,
  `ph_parasitos_dosis` decimal(10,2) NOT NULL,
  `ph_parasitos_costo` decimal(10,2) NOT NULL,
  `ph_parasitos_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_parasitos`
--

INSERT INTO `ph_parasitos` (`id`, `ph_parasitos_tagid`, `ph_parasitos_producto`, `ph_parasitos_dosis`, `ph_parasitos_costo`, `ph_parasitos_fecha`) VALUES
(1, '3000', 'Parasitin', 2.00, 2.30, '2025-01-01'),
(2, '3000', 'ParasitoKill 2', 1.50, 4.00, '2025-01-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_parasitos`
--
ALTER TABLE `ph_parasitos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_parasitos`
--
ALTER TABLE `ph_parasitos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
