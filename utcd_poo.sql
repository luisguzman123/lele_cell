-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-08-2025 a las 22:48:11
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `utcd_poo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cedula` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `apellido`, `cedula`, `correo`, `telefono`, `estado`) VALUES
(4, 'Leandro', 'Rodríguez Ramos', '5675506', 'leandro', '09565675759', 'ACTIVO'),
(5, 'Nestor', 'Lopez', '6854447', 'nestor@gmail.com', '098848484', 'ACTIVO'),
(6, 'paola', 'contreras', '65426546254', '6726547dhbsudgsyu', '9i0808989', 'ACTIVO'),
(7, 'jose', 'roman', '849249282', 'nestor@gmail.com', '89238924948', 'ACTIVO'),
(8, 'Leandro', 'Rodríguez Ramos', '5675506', 'nestor@gmail.com', '09565675759', 'ACTIVO'),
(9, 'Icho', 'Cell', '434343434', 'nestor@gmail.com', '74823748343', 'ACTIVO'),
(10, 'Leandro', 'Rodríguez Ramos', '738436543', 'nestor@gmail.com', '5u93753954', 'ACTIVO'),
(11, 'Leandro', 'Rodríguez Ramos', '738436543', 'nestor@gmail.com', '5u93753954', 'ACTIVO'),
(12, 'Leandro', 'Rodríguez Ramos', '738436543', 'nestor@gmail.com', '5437648343', 'ACTIVO'),
(13, 'lele', 'rod', '87484784', '6726547dhbsudgsyu', '09565675759', 'ACTIVO'),
(14, 'djhsjdfhjsfd', 'jhdsjhds', '74387483', 'nestor@gmail.com', '874837483', 'ACTIVO'),
(15, 'hgsuhgdjs', 'juhdjshdj', '8758347534', '6726547dhbsudgsyu', '7428478324', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_equipo`
--

CREATE TABLE `cliente_equipo` (
  `id_cliente_equipo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `imei` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_pass` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente_equipo`
--

INSERT INTO `cliente_equipo` (`id_cliente_equipo`, `id_cliente`, `id_equipo`, `imei`, `tipo_pass`, `pass`, `estado`) VALUES
(3, 4, 3, 'asd', 'PATRON', '5656', 'ACTIVO'),
(4, 5, 4, 'asd', 'CONTRASEÑA', '12', 'ACTIVO'),
(5, 4, 5, 'ASD', 'PATRON', '151A', 'ACTIVO'),
(6, 6, 6, '847389743895893', 'CONTRASEÑA', '123', 'ACTIVO'),
(7, 4, 3, '78274827482748', 'CONTRASEÑA', '123', 'ACTIVO'),
(8, 9, 7, '4736746374637', 'CONTRASEÑA', '4748964396983', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id_equipo`, `descripcion`, `marca`, `modelo`, `estado`) VALUES
(3, 'SIN DESCRIPCION', 'Apple', 'Iphone 13', 'ACTIVO'),
(4, 'algo', 'Samsung', 'A32', 'ACTIVO'),
(5, 'AS', 'Xiaomi', '7', 'ACTIVO'),
(6, 'equipo rosa', 'motorola', 'g32', 'ACTIVO'),
(7, 'Display', 'Apple', 'Xs', 'ACTIVO'),
(8, 'display muerto', 'samsungg', 'a233', 'ACTIVO'),
(9, 'display muerto', 'samsungg', 'a233', 'ACTIVO'),
(10, 'display muerto', 'samsungg', 'a233', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `id_modelo` int(11) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion_cabecera`
--

CREATE TABLE `recepcion_cabecera` (
  `id_recepcion_cabecera` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `estado` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recepcion_cabecera`
--

INSERT INTO `recepcion_cabecera` (`id_recepcion_cabecera`, `fecha`, `id_cliente`, `id_equipo`, `estado`) VALUES
(3, '2025-06-08', 4, 3, 'ANULADO'),
(4, '2025-06-08', 4, 5, 'ANULADO'),
(5, '2025-06-08', 6, 6, 'ANULADO'),
(6, '2025-06-09', 4, 3, 'ACTIVO'),
(7, '2025-06-09', 6, 6, 'ACTIVO'),
(8, '2025-06-11', 9, 7, 'ACTIVO'),
(9, '2025-06-12', 6, 6, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion_detalle`
--

CREATE TABLE `recepcion_detalle` (
  `id_recepcion_detalle` int(11) NOT NULL,
  `id_recepcion_cabecera` int(11) NOT NULL,
  `problema` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `obs` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recepcion_detalle`
--

INSERT INTO `recepcion_detalle` (`id_recepcion_detalle`, `id_recepcion_cabecera`, `problema`, `obs`, `estado`) VALUES
(6, 3, 'asdsd', 'SIN DESCRIPCION', 'ACTIVO'),
(7, 3, 'Asdas', 'SIN DESCRIPCION', 'ACTIVO'),
(8, 3, 'síndrome de Asperger', 'SIN DESCRIPCION', 'ACTIVO'),
(9, 4, 'ASDASD', 'SIN DESCRIPCION', 'ACTIVO'),
(10, 5, 'display', 'cambiar', 'ACTIVO'),
(11, 6, 'asds', 'SIN DESCRIPCION', 'ACTIVO'),
(12, 7, 'a', 'SIN DESCRIPCION', 'ACTIVO'),
(13, 7, 'a', 'a', 'ACTIVO'),
(14, 8, 'display', 'cambiar', 'ACTIVO'),
(15, 9, 'display', 'cambiar', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `cliente_equipo`
--
ALTER TABLE `cliente_equipo`
  ADD PRIMARY KEY (`id_cliente_equipo`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Indices de la tabla `recepcion_cabecera`
--
ALTER TABLE `recepcion_cabecera`
  ADD PRIMARY KEY (`id_recepcion_cabecera`);

--
-- Indices de la tabla `recepcion_detalle`
--
ALTER TABLE `recepcion_detalle`
  ADD PRIMARY KEY (`id_recepcion_detalle`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cliente_equipo`
--
ALTER TABLE `cliente_equipo`
  MODIFY `id_cliente_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recepcion_cabecera`
--
ALTER TABLE `recepcion_cabecera`
  MODIFY `id_recepcion_cabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `recepcion_detalle`
--
ALTER TABLE `recepcion_detalle`
  MODIFY `id_recepcion_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
