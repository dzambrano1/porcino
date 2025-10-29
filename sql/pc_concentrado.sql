-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:24 PM
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
-- Table structure for table `pc_concentrado`
--

CREATE TABLE `pc_concentrado` (
  `id` int(11) NOT NULL,
  `pc_concentrado_nombre` varchar(30) NOT NULL,
  `pc_concentrado_etapa` varchar(30) NOT NULL,
  `pc_concentrado_racion` decimal(10,2) NOT NULL,
  `pc_concentrado_costo` decimal(10,2) NOT NULL,
  `pc_concentrado_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_concentrado`
--

INSERT INTO `pc_concentrado` (`id`, `pc_concentrado_nombre`, `pc_concentrado_etapa`, `pc_concentrado_racion`, `pc_concentrado_costo`, `pc_concentrado_vigencia`) VALUES
(1, 'Terminador 16% (Corpoagro)', 'Engorde', 1.53, 2.35, 30),
(3, 'Crecimiento 18% (Corpoagro)', 'Crecimiento', 0.90, 0.90, 32),
(4, 'Gestacion 16% (Corpoagro)', 'Gestacion', 0.50, 1.50, 30),
(5, 'Lactantes 17.5% (Corpoagro)', 'Lactancia', 0.85, 0.65, 33),
(6, 'Preparto 15% (Corpoagro)', 'Preparto', 0.85, 0.65, 33),
(7, 'Postdestete 15% (Corpoagro)', 'Postdestete', 0.85, 0.65, 33),
(8, 'Postservicio 15% (Corpoagro)', 'Postservicio', 0.85, 0.65, 33),
(9, 'Inicio 19.5% (Corpoagro)', 'Inicio', 0.85, 0.65, 33),
(10, 'Desarrollo 18.8% (Corpoagro)', 'Crecimiento', 0.85, 0.65, 33),
(11, 'Preinicio 22% (Recuin)', 'Preinicio', 0.85, 0.65, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_concentrado`
--
ALTER TABLE `pc_concentrado`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_concentrado`
--
ALTER TABLE `pc_concentrado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
