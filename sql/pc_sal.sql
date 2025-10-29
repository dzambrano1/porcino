-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:27 PM
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
-- Table structure for table `pc_sal`
--

CREATE TABLE `pc_sal` (
  `id` int(11) NOT NULL,
  `pc_sal_nombre` varchar(30) NOT NULL,
  `pc_sal_etapa` varchar(30) NOT NULL,
  `pc_sal_racion` decimal(10,2) NOT NULL,
  `pc_sal_costo` decimal(10,2) NOT NULL,
  `pc_sal_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_sal`
--

INSERT INTO `pc_sal` (`id`, `pc_sal_nombre`, `pc_sal_etapa`, `pc_sal_racion`, `pc_sal_costo`, `pc_sal_vigencia`) VALUES
(1, 'Sal Lechones', 'Inicio', 1.53, 2.35, 30),
(3, 'Sal Crecimiento', 'Crecimiento', 0.90, 0.90, 32),
(4, 'Sal Adultos', 'Finalizacion', 0.50, 1.50, 30),
(5, 'Sal Lactantes', 'Finalizacion', 0.85, 0.65, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_sal`
--
ALTER TABLE `pc_sal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_sal`
--
ALTER TABLE `pc_sal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
