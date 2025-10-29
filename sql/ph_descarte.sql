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
-- Table structure for table `ph_descarte`
--

CREATE TABLE `ph_descarte` (
  `id` int(11) NOT NULL,
  `ph_descarte_tagid` varchar(10) NOT NULL,
  `ph_descarte_peso` decimal(10,2) NOT NULL,
  `ph_descarte_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph_descarte`
--

INSERT INTO `ph_descarte` (`id`, `ph_descarte_tagid`, `ph_descarte_peso`, `ph_descarte_fecha`) VALUES
(2, '3000', 265.00, '2025-01-01'),
(3, '3000', 300.00, '2025-01-13'),
(4, '3000', 400.00, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ph_descarte`
--
ALTER TABLE `ph_descarte`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ph_descarte`
--
ALTER TABLE `ph_descarte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
