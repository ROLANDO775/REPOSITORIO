-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2024 a las 21:38:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alcaldia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `contraseña`) VALUES
(8, 'alcaldia2025', 'alcaldia2025%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrios`
--

CREATE TABLE `barrios` (
  `id` int(11) NOT NULL,
  `barrio` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `servicio` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barrios`
--

INSERT INTO `barrios` (`id`, `barrio`, `nombre`, `apellido`, `servicio`, `ubicacion`, `telefono`) VALUES
(54, 'Sin Barrios', 'Anthony Rogelio', 'Hernández González', 'Secretario de COCODE 2021 -  2022, ALCALDE 2024', 'Camposeco', '48256820');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `difuntos`
--

CREATE TABLE `difuntos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `imagen_pago` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `difuntos`
--

INSERT INTO `difuntos` (`id`, `nombre`, `telefono`, `imagen`, `imagen_pago`) VALUES
(1, 'Juan Perez sarat', '21548796', '../difuncion/Imagen de WhatsApp 2024-10-05 a las 22.51.36_c38e1074.jpg', '../difuncion/Gráfico Diagrama de Ishikawa Profesional Azul.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_barrios`
--

CREATE TABLE `lista_barrios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista_barrios`
--

INSERT INTO `lista_barrios` (`id`, `nombre`) VALUES
(1, 'Barrio López Primero'),
(2, 'Barrio García No.1'),
(3, 'Barrio Oxlaj 1ro'),
(4, 'Barrio Gómez 1ro'),
(5, 'Barrio Hernández Pérez 1ro'),
(6, 'Barrio Hernández 1ro'),
(7, 'Barrio Chi-Martín'),
(8, 'Barrio Gómez González'),
(9, 'Barrio Zarat'),
(10, 'Barrio Velásquez 2do'),
(11, 'Barrio Velásquez Gómez'),
(12, 'Barrio Pastor Macario'),
(13, 'Barrio Matías'),
(14, 'Barrio Pastor Gonzales'),
(15, 'Barrio Pérez Gárcia'),
(16, 'Barrio Pérez 1ro'),
(17, 'Barrio González 1ro'),
(18, 'Barrio González Hernández'),
(19, 'Barrio Hernández Gómez'),
(20, 'Barrio Patzolojche 1ro'),
(21, 'Barrio Progreso'),
(22, 'Barrio Paxtor García'),
(23, 'Barrio Vásquez Pacorral'),
(24, 'Barrio Pérez Hernández 1ro'),
(25, 'Barrio González 2do'),
(26, 'Barrio Gómez 2do'),
(27, 'Barrio López 1ro'),
(28, 'Barrio Pérez 2ro'),
(29, 'Barrio González 3ro'),
(30, 'Barrio Chi-puerta y Chiramontzikin'),
(31, 'Barrio Chi-Herbán 1ro'),
(32, 'Barrio Pérez 3ro'),
(33, 'Barrio Chitalor'),
(34, 'Barrio González 4to'),
(35, 'Barrio Chaqabal'),
(36, 'Barrio Hernández 2do'),
(37, 'Barrio Vásquez Patzulcan'),
(38, 'Barrio López 2do'),
(39, 'Barrio Hernández Pérez'),
(40, 'Barrio Pérez Hernández'),
(41, 'Barrio González 5to'),
(42, 'Barrio Nuevo San Antonio'),
(43, 'Barrio Herrera'),
(44, 'Barrio Hernández Tzita'),
(45, 'Barrio Oxlaj 2do'),
(46, 'Barrio Hernández González'),
(47, 'Barrio Tzul  Baten'),
(48, 'Barrio Chi-Hernán 2do'),
(49, 'Barrio Chaj, Pastor González'),
(50, 'Barrio Gómez Hernández'),
(51, 'Barrio La Familia González'),
(52, 'Barrio Paxtor Hernández'),
(53, 'Barrio LOS HERMANOS HERNANDEZ PEREZ'),
(54, 'Barrio ESTRELLA'),
(55, 'Barrio Hernández 3ro'),
(56, 'Barrio La Familia Huinac'),
(57, 'Barrio Cmunitario cho-cruz2do'),
(58, 'Barrio González Tebalan'),
(59, 'Barrio Hernández 2023'),
(60, 'Barrio Hernández Oxlaj'),
(61, 'Sin Barrios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multas`
--

CREATE TABLE `multas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `multas`
--

INSERT INTO `multas` (`id`, `nombre`, `motivo`, `telefono`, `imagen`) VALUES
(32, 'Elmer Rolando Hernández Pérez de julian', 'no fui', '21548796', 'Imagen de WhatsApp 2024-10-14 a las 15.31.40_a097ed34.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ninos`
--

CREATE TABLE `ninos` (
  `id` int(11) NOT NULL,
  `nombre_papa` varchar(100) NOT NULL,
  `nombre_mama` varchar(100) NOT NULL,
  `nombre_nino` varchar(100) NOT NULL,
  `telefono` char(8) NOT NULL,
  `imagen_renap` varchar(255) NOT NULL,
  `imagen_pago` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ninos`
--

INSERT INTO `ninos` (`id`, `nombre_papa`, `nombre_mama`, `nombre_nino`, `telefono`, `imagen_renap`, `imagen_pago`) VALUES
(1, 'Juan Perez sarat', 'Samanta juaquinna mendes', 'si si si us', '33202129', '../niños/sanantonio.jpg', '../niños/Imagen de WhatsApp 2024-10-14 a las 15.31.40_a097ed34.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `difuntos`
--
ALTER TABLE `difuntos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lista_barrios`
--
ALTER TABLE `lista_barrios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `multas`
--
ALTER TABLE `multas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ninos`
--
ALTER TABLE `ninos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `barrios`
--
ALTER TABLE `barrios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `difuntos`
--
ALTER TABLE `difuntos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `lista_barrios`
--
ALTER TABLE `lista_barrios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `multas`
--
ALTER TABLE `multas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `ninos`
--
ALTER TABLE `ninos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
