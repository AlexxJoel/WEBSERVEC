-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2022 a las 17:24:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kof`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `magia`
--

CREATE TABLE `magia` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `magia`
--

INSERT INTO `magia` (`id`, `name`) VALUES
(1, 'fuego'),
(2, 'agua'),
(3, 'veneno'),
(4, 'fuego'),
(5, 'hielo'),
(6, 'cyborg'),
(7, 'sombra'),
(8, 'electricidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personaje`
--

CREATE TABLE `personaje` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `utiliza_magia` tinyint(4) NOT NULL,
  `estatura` double NOT NULL,
  `peso` double NOT NULL,
  `equipo` int(11) NOT NULL,
  `magia_id` int(11) DEFAULT NULL,
  `tipo_lucha_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personaje`
--

INSERT INTO `personaje` (`id`, `name`, `lastname`, `birthday`, `utiliza_magia`, `estatura`, `peso`, `equipo`, `magia_id`, `tipo_lucha_id`) VALUES
(1, 'Kenika', 'Motne', '2004-11-02', 1, 94, 35, 56, 3, 3),
(7, 'mike', 'herrera', '2003-11-02', 1, 91, 30, 50, 1, 1),
(10, 'mikee', 'herrera', '2003-11-02', 1, 91, 30, 50, 1, 1),
(18, 'mikeee', 'herrera', '2003-11-02', 1, 91, 30, 50, 1, 1),
(19, 'Kenik', 'Motne', '2004-11-02', 1, 94, 35, 56, 3, 3),
(20, 'Marios', 'Gomez', '2004-05-08', 1, 94, 80, 56, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_lucha`
--

CREATE TABLE `tipo_lucha` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_lucha`
--

INSERT INTO `tipo_lucha` (`id`, `name`) VALUES
(1, 'karate'),
(2, 'muay'),
(3, 'thai'),
(4, 'callejero'),
(5, 'propio');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `magia`
--
ALTER TABLE `magia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personaje`
--
ALTER TABLE `personaje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fk_magia` (`magia_id`),
  ADD KEY `fk_tipo_lucha` (`tipo_lucha_id`);

--
-- Indices de la tabla `tipo_lucha`
--
ALTER TABLE `tipo_lucha`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `magia`
--
ALTER TABLE `magia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `personaje`
--
ALTER TABLE `personaje`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tipo_lucha`
--
ALTER TABLE `tipo_lucha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `personaje`
--
ALTER TABLE `personaje`
  ADD CONSTRAINT `fk_magia` FOREIGN KEY (`magia_id`) REFERENCES `magia` (`id`),
  ADD CONSTRAINT `fk_tipo_lucha` FOREIGN KEY (`tipo_lucha_id`) REFERENCES `tipo_lucha` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
