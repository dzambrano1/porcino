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
-- Table structure for table `ph_anemia`
--

CREATE TABLE `ph_anemia` (
  `id` int(11) NOT NULL,
  `ph_anemia_tagid` varchar(10) NOT NULL,
  `ph_anemia_producto` varchar(50) NOT NULL,
  `ph_anemia_dosis` decimal(10,2) NOT NULL,
  `ph_anemia_costo` decimal(10,2) NOT NULL,
  `ph_anemia_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_anemia`
--

INSERT INTO `ph_anemia` (`id`, `ph_anemia_tagid`, `ph_anemia_producto`, `ph_anemia_dosis`, `ph_anemia_costo`, `ph_anemia_fecha`) VALUES
(2, '3000', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-01-06'),
(3, '74512', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-01-07'),
(4, '45422', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-01-08'),
(5, '23777', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-01-21'),
(6, '101', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-06-09'),
(7, '102', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-06-09'),
(8, '103', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-06-09'),
(9, '105', 'Iron-Dex 200 B12', 2.00, 0.50, '2025-06-09'),
(10, '121', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(11, '21241', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(12, '21522', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(13, '2542', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(14, '2125', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(15, '214', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(16, '23211', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(17, '23777', 'Hierro Dextran', 2.00, 0.50, '2025-06-09'),
(18, '24993', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(19, '252', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(20, '25422', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(21, '36242', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(22, '45242', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(23, '52526', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(24, '63211', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(25, '65422', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(26, '85221', 'Vitaferr 20', 2.00, 0.50, '2025-06-09'),
(27, '988777', 'Aftogan', 2.00, 0.50, '2025-06-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_anemia`
--
ALTER TABLE `ph_anemia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_anemia`
--
ALTER TABLE `ph_anemia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
