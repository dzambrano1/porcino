-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2025 at 07:18 PM
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
-- Table structure for table `porcino`
--

CREATE TABLE `porcino` (
  `id` int(10) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `peso_nacimiento` double(5,2) NOT NULL,
  `especie` varchar(50) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `tagid` varchar(50) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `clase` varchar(50) DEFAULT NULL,
  `raza` varchar(50) DEFAULT NULL,
  `grupo` varchar(50) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `etapa` varchar(100) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `peso_compra` double(5,2) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `fecha_venta` date DEFAULT NULL,
  `peso_venta` double(5,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `deceso_causa` varchar(30) NOT NULL,
  `deceso_fecha` date DEFAULT NULL,
  `descarte_fecha` date DEFAULT NULL,
  `descarte_peso` decimal(10,2) NOT NULL,
  `descarte_precio` decimal(10,2) NOT NULL,
  `destete_fecha` date DEFAULT NULL,
  `destete_peso` decimal(10,2) NOT NULL,
  `fecha_publicacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `porcino`
--

INSERT INTO `porcino` (`id`, `image`, `image2`, `image3`, `video`, `fecha_nacimiento`, `peso_nacimiento`, `especie`, `nombre`, `tagid`, `genero`, `clase`, `raza`, `grupo`, `estatus`, `etapa`, `edad`, `fecha_compra`, `peso_compra`, `precio_compra`, `fecha_venta`, `peso_venta`, `precio_venta`, `deceso_causa`, `deceso_fecha`, `descarte_fecha`, `descarte_peso`, `descarte_precio`, `destete_fecha`, `destete_peso`, `fecha_publicacion`) VALUES
(593, 'uploads/animal_593_1735844624.jpg', 'uploads/67fc76e219386_1744598754.jpg', 'uploads/67fc76e2198dd_1744598754.jpeg', 'uploads/videos/67fc826146cbe_1744601697.mp4', '2024-05-01', 61.00, 'Porcino', 'Piggy', '3000', 'Hembra', 'Lechona', 'Landrace', 'Vacias', 'Descartado', 'Inicio', 14, '2024-06-01', 115.00, 3.50, '2025-08-17', 200.00, 5.00, '', NULL, '2025-08-17', 200.00, 4.00, NULL, 0.00, NULL),
(614, 'uploads/Cerdito-Rosado1-removebg-preview.png', 'uploads/67fc775a40071_1744598874.jpeg', 'uploads/67fc775a40af6_1744598874.jpg', 'uploads/videos/67fc839103ab0_1744602001.mp4', '2024-09-01', 5.00, 'Porcino', 'Flor', '101', 'Hembra', 'Cerda', 'Landrace', 'Lactando', 'Muerto', 'Finalizacion', 4, '2024-04-02', 100.00, 2.90, '2025-04-01', 520.00, 3.00, 'Asfixia', '2025-06-01', NULL, 0.00, 0.00, '2025-08-17', 150.00, NULL),
(615, 'uploads/animal_615_1735844648.jpg', 'uploads/67fc782d08b2c_1744599085.png', 'uploads/67fc782d08efb_1744599085.jpeg', 'uploads/videos/67fc843901f92_1744602169.mp4', '2023-07-31', 5.00, 'Porcino', 'Titan', '102', 'Macho', 'Cerdo', 'Pietrain', 'Engorde', 'Muerto', 'Finalizacion', 9, '2024-04-04', 100.00, 3.00, '2025-03-01', 50.00, 3.01, 'Palo cochinero', '2025-08-17', NULL, 0.00, 0.00, NULL, 0.00, NULL),
(616, 'uploads/Cerdo15-removebg-preview.png', 'uploads/67fc78d308cf1_1744599251.jpg', 'uploads/67fc78d309098_1744599251.jpeg', 'uploads/videos/67fc851d4570c_1744602397.mp4', '2025-03-01', 6.00, 'Porcino', 'Choncha', '103', 'Hembra', 'Lechona', 'Yorkshire', 'Fase 2', 'Vendido', 'Finalizacion', 2, '2024-10-01', 100.00, 3.03, '2025-02-08', 520.00, 3.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(636, 'uploads/Berraco2.jpg', 'uploads/67fc79484264f_1744599368.jpg', 'uploads/67fc794842b6f_1744599368.jpg', '', '2025-03-01', 6.00, 'Porcino', 'Pepe', '105', 'Macho', 'Lechon', 'Yorkshire', 'Fase 2', 'Vendido', 'Finalizacion', 3, '2024-09-01', 100.00, 3.05, '2025-01-08', 520.00, 3.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(637, 'uploads/Baby-removebg-preview.png', 'uploads/67fc79baad7ea_1744599482.png', 'uploads/67fc79baae394_1744599482.jpeg', '', '2025-05-10', 5.00, 'Porcino', 'Piggaro', '2125', 'Macho', 'Cerdo', 'Landrace', 'Lechon', 'Vendido', 'Preinicio', 5, '2025-01-02', 100.00, 3.05, '2024-12-08', 520.00, 3.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(638, 'uploads/67fc7a760f473_1744599670.png', 'uploads/67fc7a760f7a2_1744599670.jpg', 'uploads/67fc7a760fba4_1744599670.jpg', '', '2025-03-10', 7.00, 'Porcino', 'Lolitar', '121', 'Hembra', 'Cerda', 'Hampshire', 'Fase 2', 'Vendido', 'Crecimiento', 2, '2025-01-01', 100.00, 3.20, '2024-11-08', 520.00, 3.10, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(639, 'uploads/Cerdo12-removebg-preview.png', 'uploads/67fc7b1a92296_1744599834.jpg', 'uploads/67fc7b1a92e8b_1744599834.jpeg', '', '2025-03-12', 7.00, 'Porcino', 'Rollitos', '214', 'Macho', 'Cerdo', 'Duroc', 'Engorde', 'Vendido', 'Crecimiento', 2, '2025-01-02', 100.00, 3.05, '2024-10-08', 520.00, 3.30, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(640, 'uploads/Cerdo11-removebg-preview.png', '', 'uploads/67fc7c1b640b2_1744600091.jpg', '', '2025-02-15', 7.00, 'Porcino', 'Chino', '754', 'Macho', 'Cerdo', 'Duroc', 'Sanos', 'Activo', 'CRECIMIENTO', 3, '2025-06-10', 100.00, 3.00, '2024-09-08', 520.00, 3.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(641, 'uploads/Duroc6-removebg-preview.png', 'uploads/67fc7c627417e_1744600162.jpeg', 'uploads/67fc7c627457f_1744600162.jpeg', '', '2025-03-01', 7.00, 'Porcino', 'Paton', '252', 'Macho', 'Cerdo', 'Duroc', 'Fase 2', 'Vendido', 'Crecimiento', 4, '2024-12-31', 100.00, 3.30, '2024-08-08', 520.00, 2.90, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(642, 'uploads/img_67955231bcb178.35866763.png', 'uploads/67fc7f05b7d55_1744600837.jpg', 'uploads/67fc7f05b810c_1744600837.png', '', '2024-01-01', 0.00, '', 'Rosada', '2542', 'Hembra', NULL, 'Landrace', 'Lactando', 'Descartado', 'Finalizacion', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, '2025-06-01', 30.00, 3.00, NULL, 0.00, NULL),
(644, 'uploads/img_679554a1183153.19889053.png', 'uploads/67fc7e5b35805_1744600667.jpeg', 'uploads/67fc7e5b35c09_1744600667.jpg', '', '2025-04-01', 0.00, '', 'Jim', '6625', 'Macho', NULL, 'Landrace', 'Fase 1', 'Descartado', 'Inicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, '2025-05-01', 20.00, 3.00, NULL, 0.00, NULL),
(646, 'uploads/67fc7f6d9635a_1744600941.jpg', 'uploads/67fc7f6d96c76_1744600941.jpg', 'uploads/67fc7f96a4fe4_1744600982.jpeg', '', '2025-04-15', 0.00, '', 'Royal', '45242', 'Macho', NULL, 'Hampshire', 'Fase 1', 'Activo', 'Inicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(647, 'uploads/img_679557a8d58b38.39075093.png', 'uploads/67fc80049e57e_1744601092.jpg', 'uploads/67fc80049ea1f_1744601092.jpg', '', '2025-04-24', 0.00, '', 'Amarillo', '25422', 'Macho', NULL, 'Yorkshire', 'Fase 1', 'Vendido', 'Inicio', NULL, NULL, 0.00, 0.00, '2025-08-20', 50.00, 4.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(648, 'uploads/img_679557f3f2baa4.48553351.png', '', '', '', '2025-05-15', 0.00, '', 'Blanquito', '23211', 'Macho', NULL, 'Landrace', 'Lechon', 'Muerto', 'Preinicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, 'Infarto', '2025-08-20', NULL, 0.00, 0.00, NULL, 0.00, NULL),
(649, 'uploads/img_67955829681fd0.79463197.png', '', '', '', '2025-04-20', 0.00, '', 'Chanchita', '63211', 'Macho', NULL, 'Landrace', 'Fase 1', 'Descartado', 'Inicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, '2025-08-20', 20.00, 4.00, NULL, 0.00, NULL),
(650, 'uploads/img_67955870144667.56859303.png', '', '', '', '2025-03-12', 0.00, '', 'Chino', '63522', 'Macho', NULL, 'Pietrain', 'Fase 2', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(651, 'uploads/img_679558dc6f3ca7.26136957.png', '', '', '', '2025-02-01', 0.00, '', 'Duro', '74512', 'Macho', NULL, 'Pietrain', 'Engorde', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(652, 'uploads/Cerdo14-removebg-preview.png', '', '', '', '2025-02-01', 0.00, '', 'Roble', '75422', 'Macho', NULL, 'Duroc', 'Engorde', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(653, 'uploads/img_67955a403f3989.44419375.png', '', '', '', '2025-02-02', 0.00, '', 'Nikita', '21522', 'Hembra', NULL, 'Yorkshire', 'Gestacion', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(654, 'uploads/img_67955a775fa7d4.20284442.png', '', '', '', '2025-02-05', 0.00, '', 'Petra', '85221', 'Hembra', NULL, 'Pietrain', 'Gestacion', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(655, 'uploads/img_67955aa4003f96.13718133.png', '', '', '', '2021-05-01', 0.00, '', 'Lunares', '21241', 'Macho', NULL, 'Pietrain', 'Engorde', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(656, 'uploads/img_67955ad6c96c28.76650945.png', '', '', '', '2025-03-01', 0.00, '', 'Griselda', '24993', 'Hembra', NULL, 'Pietrain', 'Lactando', 'Vendido', 'Crecimiento', NULL, NULL, 0.00, 0.00, '2025-08-17', 200.00, 4.00, 'Golpe', '2025-01-15', NULL, 0.00, 0.00, '2025-08-03', 150.00, NULL),
(657, 'uploads/img_67955b0cee8f42.99008479.png', '', '', '', '2025-03-01', 0.00, '', 'Barbas', '93688', 'Macho', NULL, 'Pietrain', 'Engorde', 'Muerto', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, 'Golpe', '2025-02-10', NULL, 0.00, 0.00, '2025-02-01', 250.00, NULL),
(658, 'uploads/img_67955b4eae6617.36026010.png', '', '', '', '2025-02-10', 0.00, '', 'Orejas', '23777', 'Macho', NULL, 'Duroc', 'Engorde', 'Muerto', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, 'Golpe', '2025-03-15', NULL, 0.00, 0.00, '2025-03-01', 150.00, NULL),
(659, 'uploads/img_67955b987967b2.35919895.png', '', '', '', '2025-02-01', 0.00, '', 'Veladora', '988777', 'Hembra', NULL, 'Duroc', 'Gestacion', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(660, 'uploads/img_67955be6a3fd49.24432142.jpeg', '', '', '', '2024-05-01', 0.00, '', 'Dormilona', '65422', 'Hembra', NULL, 'Pietrain', 'Lactando', 'Activo', 'Crecimiento', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(661, 'uploads/img_67955c247b4089.80772508.jpeg', '', '', '', '2025-04-15', 0.00, '', 'Roky', '36242', 'Macho', NULL, 'Pietrain', 'Fase 1', 'Activo', 'Inicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(662, 'uploads/6823744e05248_Pietrain-baby.jpg', 'uploads/6823744e055a7_pietrain-baby2.jpg', 'uploads/6823744e05a2b_pietrain-baby3.jpg', 'uploads/6823744e07c5e_pietrain-pig-video.mp4', '2025-06-15', 51.00, '', 'Manchado', '52526', 'Macho', NULL, 'Pietrain', 'Sanos', 'Activo', 'Preinicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(663, 'uploads/684746fa64e7f_1749501690.jpg', 'uploads/684746fa65a97_1749501690.jpg', 'uploads/684746fa65fba_1749501690.jpg', 'uploads/videos/684746fa66523_1749501690.mp4', '2025-02-01', 0.00, '', 'Regio', '7575', 'Macho', NULL, 'Duroc', 'Engorde', 'Activo', 'Finalizacion', NULL, '2025-06-01', 80.00, 3.10, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(664, 'uploads/684755805cfad_pietrain-image1.jpg', 'uploads/684755805d3bd_pietrain-image2.jpg', 'uploads/684755805d899_pietrain-image3.jpg', 'uploads/684755805e1c8_pietrain-video.mp4', '2025-01-02', 200.00, '', 'Robusto', '9898', 'Macho', NULL, 'Pietrain', 'Engorde', 'Muerto', 'Inicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, 'Coñazo', '2025-05-01', NULL, 0.00, 0.00, NULL, 0.00, NULL),
(665, 'uploads/68a114e03d9e1_1755387104.jpeg', 'uploads/68a114e03dd57_1755387104.jpg', 'uploads/68a114e03dfd2_1755387104.jpeg', '', '2025-01-01', 0.00, '', 'Chingon', '8695', 'Macho', NULL, 'Duroc', 'Sanos', 'Activo', 'CRECIMIENTO', NULL, '2025-01-25', 120.00, 4.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(666, 'uploads/68a1190859c01_pietrain3-lechon.jpg', 'uploads/68a1190859f11_pietrain2-lechon.jpg', 'uploads/68a119085a0e2_Cerdo2.jpg', NULL, '2025-07-01', 50.00, '', 'Pier', '3333', 'Macho', NULL, 'Pietrain', 'Sanos', 'Activo', 'Inicio', NULL, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `porcino`
--
ALTER TABLE `porcino`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tagid` (`tagid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `porcino`
--
ALTER TABLE `porcino`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=667;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
