-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:26 PM
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
-- Table structure for table `pc_melaza`
--

CREATE TABLE `pc_melaza` (
  `id` int(11) NOT NULL,
  `pc_melaza_nombre` varchar(30) NOT NULL,
  `pc_melaza_etapa` varchar(30) NOT NULL,
  `pc_melaza_racion` decimal(10,2) NOT NULL,
  `pc_melaza_costo` decimal(10,2) NOT NULL,
  `pc_melaza_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_melaza`
--

INSERT INTO `pc_melaza` (`id`, `pc_melaza_nombre`, `pc_melaza_etapa`, `pc_melaza_racion`, `pc_melaza_costo`, `pc_melaza_vigencia`) VALUES
(1, 'CENTRAL PORTUGUESA', 'Inicio', 1.53, 2.35, 30),
(3, 'ASOBARINAS', 'Crecimiento', 0.90, 0.90, 32),
(4, 'AGRICOLA BICOLOR C.A', 'Finalizacion', 0.50, 1.50, 30),
(5, 'ACCE MASCOTAS CA', 'Finalizacion', 0.85, 0.65, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_melaza`
--
ALTER TABLE `pc_melaza`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_melaza`
--
ALTER TABLE `pc_melaza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
