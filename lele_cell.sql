-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2025 a las 01:07:17
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lele_cell`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `cedula` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(80) NOT NULL,
  `estado` varchar(20) NOT NULL
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
  `imei` varchar(50) NOT NULL,
  `tipo_pass` varchar(80) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `estado` varchar(30) NOT NULL
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
-- Estructura de tabla para la tabla `compra_cabecera`
--

CREATE TABLE `compra_cabecera` (
  `id_compra` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `total_exenta` int(11) DEFAULT NULL,
  `total_iva5` int(11) DEFAULT NULL,
  `total_iva10` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_detalle`
--

CREATE TABLE `compra_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Disparadores `compra_detalle`
--
DELIMITER $$
CREATE TRIGGER `trg_compra_detalle_after_insert` AFTER INSERT ON `compra_detalle` FOR EACH ROW BEGIN
  UPDATE producto
    SET stock = stock + NEW.cantidad
  WHERE id_producto = NEW.id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(80) NOT NULL,
  `estado` varchar(30) NOT NULL
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
  `descripcion` varchar(150) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `id_modelo` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra_cabecera`
--

CREATE TABLE `orden_compra_cabecera` (
  `id_orden` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `id_presupuesto` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `orden_compra_cabecera`
--

INSERT INTO `orden_compra_cabecera` (`id_orden`, `fecha`, `observacion`, `id_proveedor`, `total`, `id_presupuesto`, `id_usuario`, `estado`) VALUES
(7, '2025-08-03', '', 2, 250000, 8, 1, 'APROBADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra_detalle`
--

CREATE TABLE `orden_compra_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `orden_compra_detalle`
--

INSERT INTO `orden_compra_detalle` (`id_detalle`, `id_orden`, `id_producto`, `cantidad`, `precio`) VALUES
(8, 7, 4, 5, 50000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_proveedor_cabecera`
--

CREATE TABLE `pedido_proveedor_cabecera` (
  `id_pedido` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pedido_proveedor_cabecera`
--

INSERT INTO `pedido_proveedor_cabecera` (`id_pedido`, `fecha`, `observacion`, `id_proveedor`, `id_usuario`, `estado`) VALUES
(6, '2025-08-03', '', 2, 1, 'UTILIZADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_proveedor_detalle`
--

CREATE TABLE `pedido_proveedor_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pedido_proveedor_detalle`
--

INSERT INTO `pedido_proveedor_detalle` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`) VALUES
(7, 6, 4, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_cabecera`
--

CREATE TABLE `presupuesto_cabecera` (
  `id_presupuesto` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `id_proveedor` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `presupuesto_cabecera`
--

INSERT INTO `presupuesto_cabecera` (`id_presupuesto`, `fecha`, `observacion`, `id_proveedor`, `total`, `id_usuario`, `estado`) VALUES
(8, '2025-08-03', '', 2, 250000, 1, 'APROBADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_detalle`
--

CREATE TABLE `presupuesto_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `presupuesto_detalle`
--

INSERT INTO `presupuesto_detalle` (`id_detalle`, `id_presupuesto`, `id_producto`, `cantidad`, `precio`) VALUES
(9, 8, 4, 5, 50000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `estado` varchar(30) NOT NULL,
  `iva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `precio`, `stock`, `estado`, `iva`) VALUES
(4, 'producto', 30000, 6, 'ACTIVO', 10),
(5, 'A', 60000, 0, 'ACTIVO', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) DEFAULT NULL,
  `ruc` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `ruc`, `telefono`, `estado`) VALUES
(2, 'LUCHOCELL', '6959595-8', '0959595', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuesto`
--

CREATE TABLE `repuesto` (
  `id_repuesto` int(11) NOT NULL,
  `nombre_repuesto` varchar(100) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `repuesto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_cabecera`
--

CREATE TABLE `factura_cabecera` (
  `id_factura_cabecera` int(11) NOT NULL,
  `nro_factura` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `condicion` varchar(20) DEFAULT NULL,
  `timbrado` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE `factura_detalle` (
  `id_factura_detalle` int(11) NOT NULL,
  `id_factura_cabecera` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `factura_detalle`
--
DELIMITER $$
CREATE TRIGGER `trg_factura_detalle_after_insert` AFTER INSERT ON `factura_detalle` FOR EACH ROW BEGIN
  UPDATE producto
    SET stock = stock - NEW.cantidad
  WHERE id_producto = NEW.id_producto;
END
$$
DELIMITER ;

--
-- Disparadores `factura_cabecera`
--
DELIMITER $$
CREATE TRIGGER `trg_factura_cabecera_after_update` AFTER UPDATE ON `factura_cabecera` FOR EACH ROW BEGIN
  IF NEW.estado = 'ANULADO' AND OLD.estado <> 'ANULADO' THEN
    UPDATE producto p
      JOIN factura_detalle fd ON fd.id_producto = p.id_producto
      SET p.stock = p.stock + fd.cantidad
      WHERE fd.id_factura_cabecera = NEW.id_factura_cabecera;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnico`
--

CREATE TABLE `tecnico` (
  `id_tecnico` int(11) NOT NULL,
  `nombre_tecnico` varchar(100) DEFAULT NULL,
  `cedula` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tecnico`
--

INSERT INTO `tecnico` (`id_tecnico`, `nombre_tecnico`, `cedula`, `telefono`, `estado`) VALUES
(1, 'Tecnico Prueba', '1234567', '0981000000', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion_cabecera`
--

CREATE TABLE `recepcion_cabecera` (
  `id_recepcion_cabecera` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
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
  `problema` varchar(200) NOT NULL,
  `obs` varchar(200) NOT NULL,
  `estado` varchar(20) NOT NULL
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
  `descripcion` varchar(150) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

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
-- Indices de la tabla `compra_cabecera`
--
ALTER TABLE `compra_cabecera`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compra_cabecera_usuario` (`id_usuario`);

--
-- Indices de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_compra_detalle_cabecera` (`id_compra`),
  ADD KEY `fk_compra_detalle_producto` (`id_producto`);

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
-- Indices de la tabla `orden_compra_cabecera`
--
ALTER TABLE `orden_compra_cabecera`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `fk_orden_compra_cabecera_usuario` (`id_usuario`);

--
-- Indices de la tabla `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `pedido_proveedor_cabecera`
--
ALTER TABLE `pedido_proveedor_cabecera`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_proveedor_cabecera_proveedor` (`id_proveedor`),
  ADD KEY `fk_pedido_proveedor_cabecera_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_proveedor_detalle`
--
ALTER TABLE `pedido_proveedor_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_pedido_proveedor_detalle_cabecera` (`id_pedido`),
  ADD KEY `fk_pedido_proveedor_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `presupuesto_cabecera`
--
ALTER TABLE `presupuesto_cabecera`
  ADD PRIMARY KEY (`id_presupuesto`),
  ADD KEY `fk_presupuesto_cabecera_usuario` (`id_usuario`);

--
-- Indices de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_presupuesto1` (`id_presupuesto`),
  ADD KEY `fk_detalle_producto1` (`id_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_tipo_producto` (`estado`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  ADD PRIMARY KEY (`id_repuesto`);

--
-- Indices de la tabla `factura_cabecera`
--
ALTER TABLE `factura_cabecera`
  ADD PRIMARY KEY (`id_factura_cabecera`),
  ADD KEY `fk_factura_cabecera_cliente` (`id_cliente`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`id_factura_detalle`),
  ADD KEY `fk_factura_detalle_cabecera` (`id_factura_cabecera`),
  ADD KEY `fk_factura_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id_tecnico`);

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
-- AUTO_INCREMENT de la tabla `compra_cabecera`
--
ALTER TABLE `compra_cabecera`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT de la tabla `orden_compra_cabecera`
--
ALTER TABLE `orden_compra_cabecera`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pedido_proveedor_cabecera`
--
ALTER TABLE `pedido_proveedor_cabecera`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedido_proveedor_detalle`
--
ALTER TABLE `pedido_proveedor_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `presupuesto_cabecera`
--
ALTER TABLE `presupuesto_cabecera`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  MODIFY `id_repuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  MODIFY `id_tecnico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT de la tabla `factura_cabecera`
--
ALTER TABLE `factura_cabecera`
  MODIFY `id_factura_cabecera` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `id_factura_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- Estructura de tabla para la tabla `diagnostico_cabecera`
--
CREATE TABLE `diagnostico_cabecera` (
  `id_diagnostico` int(11) NOT NULL,
  `id_recepcion_cabecera` int(11) NOT NULL,
  `fecha_diagnostico` datetime NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `costo_estimado` decimal(10,2) DEFAULT 0,
  `estado_diagnostico` varchar(20) DEFAULT 'Pendiente',
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Estructura de tabla para la tabla `diagnostico_detalle`
--
CREATE TABLE `diagnostico_detalle` (
  `id_diagnostico_detalle` int(11) NOT NULL,
  `id_diagnostico` int(11) NOT NULL,
  `descripcion_prueba` varchar(200) DEFAULT NULL,
  `resultado` varchar(100) DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indices de la tabla `diagnostico_cabecera`
--
ALTER TABLE `diagnostico_cabecera`
  ADD PRIMARY KEY (`id_diagnostico`);

--
-- Indices de la tabla `diagnostico_detalle`
--
ALTER TABLE `diagnostico_detalle`
  ADD PRIMARY KEY (`id_diagnostico_detalle`);

--
-- AUTO_INCREMENT de la tabla `diagnostico_cabecera`
--
ALTER TABLE `diagnostico_cabecera`
  MODIFY `id_diagnostico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diagnostico_detalle`
--
ALTER TABLE `diagnostico_detalle`
  MODIFY `id_diagnostico_detalle` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `presupuesto_servicio_cabecera`
-- --------------------------------------------------------
CREATE TABLE `presupuesto_servicio_cabecera` (
  `id_presupuesto_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_diagnostico` int(11) NOT NULL,
  `fecha_presupuesto` date NOT NULL DEFAULT curdate(),
  `validez_dias` int(11) NOT NULL DEFAULT 7,
  `estado` varchar(20) NOT NULL DEFAULT 'Enviado',
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id_presupuesto_servicio`),
  KEY `fk_presu_diag` (`id_diagnostico`),
  CONSTRAINT `fk_presu_diag` FOREIGN KEY (`id_diagnostico`) REFERENCES `diagnostico_cabecera` (`id_diagnostico`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `presupuesto_servicio_detalle`
-- --------------------------------------------------------
CREATE TABLE `presupuesto_servicio_detalle` (
  `id_detalle_presu` int(11) NOT NULL AUTO_INCREMENT,
  `id_presupuesto_servicio` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` int(11) NOT NULL,
  `subtotal` int(11) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED,
  PRIMARY KEY (`id_detalle_presu`),
  KEY `fk_detalle_presu_cab` (`id_presupuesto_servicio`),
  CONSTRAINT `fk_detalle_presu_cab` FOREIGN KEY (`id_presupuesto_servicio`) REFERENCES `presupuesto_servicio_cabecera` (`id_presupuesto_servicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `servicio_cabecera`
-- --------------------------------------------------------
CREATE TABLE servicio_cabecera (
  id_servicio INT AUTO_INCREMENT PRIMARY KEY,
  id_presupuesto INT NOT NULL,
  id_tecnico INT NULL,
  fecha_inicio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_fin DATETIME NULL,
  estado VARCHAR(20) NOT NULL DEFAULT 'En Proceso',
  observaciones TEXT,
  total_general INT NOT NULL DEFAULT 0,
  CONSTRAINT fk_srv_presu
    FOREIGN KEY (id_presupuesto)
    REFERENCES presupuesto_servicio_cabecera(id_presupuesto_servicio)
      ON DELETE RESTRICT
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `servicio_detalle`
-- --------------------------------------------------------
CREATE TABLE servicio_detalle (
  id_detalle_srv INT AUTO_INCREMENT PRIMARY KEY,
  id_servicio INT NOT NULL,
  tarea VARCHAR(100) NOT NULL,
  horas_trabajadas DECIMAL(5,2) NOT NULL DEFAULT 0,
  observaciones TEXT,
  CONSTRAINT fk_det_srv
    FOREIGN KEY (id_servicio)
    REFERENCES servicio_cabecera(id_servicio)
      ON DELETE CASCADE
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `servicio_repuesto`
-- --------------------------------------------------------
CREATE TABLE servicio_repuesto (
  id_srv_rep INT AUTO_INCREMENT PRIMARY KEY,
  id_servicio INT NOT NULL,
  id_repuesto INT NOT NULL,
  cantidad INT NOT NULL DEFAULT 1,
  CONSTRAINT fk_srvrep_srv
    FOREIGN KEY (id_servicio)
    REFERENCES servicio_cabecera(id_servicio)
      ON DELETE CASCADE
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `servicio_garantia`
-- --------------------------------------------------------
CREATE TABLE servicio_garantia (
  id_garantia INT AUTO_INCREMENT PRIMARY KEY,
  id_servicio INT NOT NULL,
  fecha_inicio DATE NOT NULL DEFAULT CURRENT_DATE,
  duracion_dias INT NOT NULL DEFAULT 30,
  estado VARCHAR(20) NOT NULL DEFAULT 'Vigente',
  CONSTRAINT fk_gar_srv
    FOREIGN KEY (id_servicio)
    REFERENCES servicio_cabecera(id_servicio)
      ON DELETE CASCADE

-- Estructura de tabla para la tabla `servicio_entrega`
-- --------------------------------------------------------
CREATE TABLE servicio_entrega (
  id_entrega INT AUTO_INCREMENT PRIMARY KEY,
  id_servicio INT NOT NULL,
  fecha_entrega DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  firmado_por VARCHAR(100) NULL,
  CONSTRAINT fk_ent_srv
    FOREIGN KEY (id_servicio)
    REFERENCES servicio_cabecera(id_servicio)
      ON DELETE RESTRICT

      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
