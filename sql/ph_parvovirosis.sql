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
-- Table structure for table `ph_parvovirosis`
--

CREATE TABLE `ph_parvovirosis` (
  `id` int(11) NOT NULL,
  `ph_parvovirosis_tagid` varchar(10) NOT NULL,
  `ph_parvovirosis_producto` varchar(50) NOT NULL,
  `ph_parvovirosis_dosis` decimal(10,2) NOT NULL,
  `ph_parvovirosis_costo` decimal(10,2) NOT NULL,
  `ph_parvovirosis_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_parvovirosis`
--

INSERT INTO `ph_parvovirosis` (`id`, `ph_parvovirosis_tagid`, `ph_parvovirosis_producto`, `ph_parvovirosis_dosis`, `ph_parvovirosis_costo`, `ph_parvovirosis_fecha`) VALUES
(1, '102', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05'),
(2, '103', 'Farrowsure Gold b', 2.00, 1.50, '2024-01-06'),
(3, '105', 'Farrowsure Gold b', 2.00, 1.50, '2025-01-07'),
(4, '21241', 'Farrowsure Gold b', 2.00, 1.50, '2025-01-07'),
(5, '2125', 'Farrowsure Gold b', 2.00, 1.50, '2025-01-21'),
(6, '214', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(7, '23211', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(8, '23777', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(9, '252', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(10, '25422', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(11, '36242', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(12, '45242', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(13, '52526', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(14, '63211', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(15, '63522', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(16, '6625', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(17, '74512', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(18, '754', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(19, '75422', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(20, '7575', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(21, '93688', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(22, '9898', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(23, '101', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(24, '103', 'Farrowsure Gold b', 2.00, 1.50, '2025-06-09'),
(25, '121', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05'),
(26, '24993', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05'),
(27, '2542', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05'),
(28, '65422', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05'),
(29, '85221', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05'),
(30, '988777', 'Farrowsure Gold b', 2.00, 1.50, '2023-01-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_parvovirosis`
--
ALTER TABLE `ph_parvovirosis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_parvovirosis`
--
ALTER TABLE `ph_parvovirosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
