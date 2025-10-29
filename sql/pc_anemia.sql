-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:20 PM
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
-- Table structure for table `pc_anemia`
--

CREATE TABLE `pc_anemia` (
  `id` int(11) NOT NULL,
  `pc_anemia_vacuna` varchar(30) NOT NULL,
  `pc_anemia_dosis` decimal(10,2) NOT NULL,
  `pc_anemia_costo` decimal(10,2) NOT NULL,
  `pc_anemia_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_anemia`
--

INSERT INTO `pc_anemia` (`id`, `pc_anemia_vacuna`, `pc_anemia_dosis`, `pc_anemia_costo`, `pc_anemia_vigencia`) VALUES
(1, 'Iron-Dex 200 B12', 2.00, 0.02, 180),
(3, 'Edo Hierro Dextran', 0.30, 0.88, 180),
(4, 'Vitaferr 20', 0.50, 1.50, 180),
(5, 'Ferrovet 100', 0.50, 1.50, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pc_anemia`
--
ALTER TABLE `pc_anemia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pc_anemia`
--
ALTER TABLE `pc_anemia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
