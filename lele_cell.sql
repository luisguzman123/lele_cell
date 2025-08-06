-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-08-2025 a las 19:13:56
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
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id_auditoria` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `accion` varchar(20) NOT NULL,
  `tabla` varchar(50) NOT NULL,
  `id_registro` int(11) DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id_auditoria`, `id_usuario`, `usuario`, `accion`, `tabla`, `id_registro`, `detalles`, `fecha`) VALUES
(1, 1, 'admin', 'UPDATE', 'usuario', 2, '{\"usuario\":\"leandro\",\"password\":\"123\",\"id_cargo\":\"2\",\"id_permiso\":\"2\",\"id_usuario\":\"2\"}', '2025-08-06 16:10:05'),
(2, 1, 'admin', 'DELETE', 'usuario', 3, NULL, '2025-08-06 16:10:12'),
(3, 1, 'admin', 'INSERT', 'cliente', 1, '{\"nombre\":\"Luis\",\"apellido\":\"Galeano\",\"cedula\":\"2316548\",\"correo\":\"luisgale@gmail.com\",\"telefono\":\"098547854\",\"estado\":\"ACTIVO\"}', '2025-08-06 16:17:07'),
(4, 1, 'admin', 'INSERT', 'compra_cabecera', 1, '{\"fecha\":\"2025-08-06\",\"observacion\":\"\",\"id_proveedor\":\"1\",\"id_orden\":\"1\",\"total_exenta\":0,\"total_iva5\":0,\"total_iva10\":260000,\"total\":260000,\"estado\":\"ACTIVO\",\"id_usuario\":1}', '2025-08-06 16:24:03'),
(5, 1, 'admin', 'INSERT', 'compra_detalle', NULL, '{\"id_compra\":\"1\",\"id_producto\":\"1\",\"cantidad\":\"1\",\"precio\":30000}', '2025-08-06 16:24:03'),
(6, 1, 'admin', 'INSERT', 'compra_detalle', NULL, '{\"id_compra\":\"1\",\"id_producto\":\"2\",\"cantidad\":\"2\",\"precio\":25000}', '2025-08-06 16:24:03'),
(7, 1, 'admin', 'INSERT', 'compra_detalle', NULL, '{\"id_compra\":\"1\",\"id_producto\":\"3\",\"cantidad\":\"3\",\"precio\":60000}', '2025-08-06 16:24:03'),
(8, 1, 'admin', 'LOGOUT', 'usuario', 1, NULL, '2025-08-06 17:04:03'),
(9, 1, 'admin', 'LOGIN', 'usuario', 1, NULL, '2025-08-06 17:10:00'),
(10, 1, 'admin', 'INSERT', 'compra_cabecera', 2, '{\"fecha\":\"2025-08-06\",\"observacion\":\"\",\"id_proveedor\":\"2\",\"id_orden\":\"0\",\"nro_factura\":\"001-001-0000006\",\"timbrado\":\"123456\",\"total_exenta\":0,\"total_iva5\":0,\"total_iva10\":40000,\"total\":40000,\"estado\":\"ACTIVO\",\"id_usuario\":1}', '2025-08-06 17:12:06'),
(11, 1, 'admin', 'INSERT', 'compra_detalle', NULL, '{\"id_compra\":\"2\",\"id_producto\":\"10\",\"cantidad\":\"1\",\"precio\":40000}', '2025-08-06 17:12:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_registro`
--

CREATE TABLE `caja_registro` (
  `id_registro` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `monto_apertura` int(11) NOT NULL DEFAULT 0,
  `efectivo` int(11) NOT NULL DEFAULT 0,
  `tarjeta` int(11) NOT NULL DEFAULT 0,
  `transferencia` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `accion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja_registro`
--

INSERT INTO `caja_registro` (`id_registro`, `id_caja`, `id_usuario`, `fecha`, `monto_apertura`, `efectivo`, `tarjeta`, `transferencia`, `total`, `accion`) VALUES
(1, 1, 1, '2025-08-06 13:24:27', 200000, 0, 0, 0, 200000, 'ABRIR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `descripcion`, `estado`) VALUES
(1, 'Administrador', 'ACTIVO'),
(2, 'Secretaria', 'ACTIVO');

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
(1, 'Luis', 'Galeano', '2316548', 'luisgale@gmail.com', '098547854', 'ACTIVO');

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
(1, 1, 3, '59595955959', 'PATRON', '123', 'ACTIVO');

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
  `nro_factura` varchar(20) NOT NULL,
  `timbrado` varchar(20) NOT NULL,
  `total_exenta` int(11) DEFAULT NULL,
  `total_iva5` int(11) DEFAULT NULL,
  `total_iva10` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compra_cabecera`
--

INSERT INTO `compra_cabecera` (`id_compra`, `fecha`, `observacion`, `id_proveedor`, `id_orden`, `nro_factura`, `timbrado`, `total_exenta`, `total_iva5`, `total_iva10`, `total`, `id_usuario`, `estado`) VALUES
(1, '2025-08-06', '', 1, 1, '', '', 0, 0, 260000, 260000, 1, 'ACTIVO'),
(2, '2025-08-06', '', 2, 0, '001-001-0000006', '123456', 0, 0, 40000, 40000, 1, 'ACTIVO');

--
-- Disparadores `compra_cabecera`
--
DELIMITER $$
CREATE TRIGGER `trg_after_update_estado_compra` AFTER UPDATE ON `compra_cabecera` FOR EACH ROW BEGIN
    IF NEW.estado = 'ANULADO' AND OLD.estado <> 'ANULADO' THEN
        UPDATE producto p
        JOIN compra_detalle cd ON p.id_producto = cd.id_producto
        SET p.stock = p.stock + cd.cantidad
        WHERE cd.id_compra = NEW.id_compra;
    END IF;
END
$$
DELIMITER ;

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
-- Volcado de datos para la tabla `compra_detalle`
--

INSERT INTO `compra_detalle` (`id_detalle`, `id_compra`, `id_producto`, `cantidad`, `precio`) VALUES
(1, 1, 1, 1, 30000),
(2, 1, 2, 2, 25000),
(3, 1, 3, 3, 60000),
(4, 2, 10, 1, 40000);

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
-- Estructura de tabla para la tabla `diagnostico_cabecera`
--

CREATE TABLE `diagnostico_cabecera` (
  `id_diagnostico` int(11) NOT NULL,
  `id_recepcion_cabecera` int(11) NOT NULL,
  `fecha_diagnostico` date NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `costo_estimado` int(11) DEFAULT 0,
  `estado_diagnostico` varchar(20) DEFAULT 'PENDIENTE',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `diagnostico_cabecera`
--

INSERT INTO `diagnostico_cabecera` (`id_diagnostico`, `id_recepcion_cabecera`, `fecha_diagnostico`, `id_tecnico`, `costo_estimado`, `estado_diagnostico`, `observaciones`) VALUES
(1, 1, '2025-08-06', 1, 0, 'UTILIZADO', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico_detalle`
--

CREATE TABLE `diagnostico_detalle` (
  `id_diagnostico_detalle` int(11) NOT NULL,
  `id_diagnostico` int(11) NOT NULL,
  `descripcion_prueba` varchar(200) DEFAULT NULL,
  `resultado` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `diagnostico_detalle`
--

INSERT INTO `diagnostico_detalle` (`id_diagnostico_detalle`, `id_diagnostico`, `descripcion_prueba`, `resultado`, `observaciones`) VALUES
(1, 1, 'Se realizo la verificacion', 'dañado', 'se debe de cambiar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_productos_cabecera`
--

CREATE TABLE `entrada_productos_cabecera` (
  `id_entrada` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `documento_referencia` varchar(50) NOT NULL,
  `observaciones` varchar(100) NOT NULL,
  `usuario_registro` varchar(50) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `entrada_productos_cabecera`
--
DELIMITER $$
CREATE TRIGGER `trg_anular_movimiento` AFTER UPDATE ON `entrada_productos_cabecera` FOR EACH ROW BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE v_producto INT;
  DECLARE v_cantidad INT;

  -- Cursor para recorrer los productos asociados a la cabecera
  DECLARE cur CURSOR FOR
    SELECT id_producto, cantidad
    FROM entrada_salida_detalle
    WHERE id_entrada = NEW.id_entrada;

  -- Manejo de final del cursor
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  -- Solo si se cambió a ANULADO
  IF NEW.estado = 'ANULADO' AND OLD.estado <> 'ANULADO' THEN
    OPEN cur;
    leer_loop: LOOP
      FETCH cur INTO v_producto, v_cantidad;
      IF done THEN
        LEAVE leer_loop;
      END IF;

      -- Usamos documento_referencia como tipo
      IF NEW.documento_referencia = 'Entrada' THEN
        UPDATE producto SET stock = stock - v_cantidad WHERE id_producto = v_producto;
      ELSEIF NEW.documento_referencia = 'Salida' THEN
        UPDATE producto SET stock = stock + v_cantidad WHERE id_producto = v_producto;
      END IF;

    END LOOP;
    CLOSE cur;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_salida_detalle`
--

CREATE TABLE `entrada_salida_detalle` (
  `id_entrada_detalle` int(11) NOT NULL,
  `id_entrada` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `entrada_salida_detalle`
--
DELIMITER $$
CREATE TRIGGER `trg_actualizar_stock_ajuste` AFTER INSERT ON `entrada_salida_detalle` FOR EACH ROW BEGIN
  DECLARE tipo_movimiento VARCHAR(20);

  -- Obtenemos el tipo desde la cabecera
  SELECT documento_referencia INTO tipo_movimiento
  FROM entrada_productos_cabecera
  WHERE id_entrada = NEW.id_entrada;

  -- Si es Entrada, sumamos stock
  IF tipo_movimiento = 'Entrada' THEN
    UPDATE producto
    SET stock = stock + NEW.cantidad
    WHERE id_producto = NEW.id_producto;

  -- Si es Salida, restamos stock
  ELSEIF tipo_movimiento = 'Salida' THEN
    UPDATE producto
    SET stock = stock - NEW.cantidad
    WHERE id_producto = NEW.id_producto;
  END IF;
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
(8, 'display muerto', 'samsungg', 'a22', 'ACTIVO');

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
  `tipo_pago` varchar(50) NOT NULL,
  `timbrado` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `id_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `factura_cabecera`
--

INSERT INTO `factura_cabecera` (`id_factura_cabecera`, `nro_factura`, `fecha`, `id_cliente`, `condicion`, `tipo_pago`, `timbrado`, `estado`, `id_registro`) VALUES
(1, '001-001-0000001', '2025-08-06', 1, 'CONTADO', 'Efectivo', '123456', 'ACTIVO', 1);

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
-- Volcado de datos para la tabla `factura_detalle`
--

INSERT INTO `factura_detalle` (`id_factura_detalle`, `id_factura_cabecera`, `id_producto`, `cantidad`, `precio`) VALUES
(1, 1, 1, 1, 60000),
(2, 1, 2, 1, 50000);

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
(1, '2025-08-06', '', 1, 260000, 1, 1, 'APROBADO');

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
(1, 1, 1, 1, 30000),
(2, 1, 2, 2, 25000),
(3, 1, 3, 3, 60000);

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
(1, '2025-08-06', '', 1, 1, 'UTILIZADO');

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
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 1, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `descripcion`, `estado`) VALUES
(1, 'Administrador', 'ACTIVO'),
(2, 'Secretaria', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_pago_cabecera`
--

CREATE TABLE `plan_pago_cabecera` (
  `id_plan` int(11) NOT NULL,
  `id_factura_cabecera` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `plan_pago_cabecera`
--

INSERT INTO `plan_pago_cabecera` (`id_plan`, `id_factura_cabecera`, `total`) VALUES
(1, 4, 510000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_pago_detalle`
--

CREATE TABLE `plan_pago_detalle` (
  `id_plan_detalle` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `nro_cuota` int(11) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `monto_cuota` int(11) NOT NULL,
  `estado` varchar(20) DEFAULT 'PENDIENTE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `plan_pago_detalle`
--

INSERT INTO `plan_pago_detalle` (`id_plan_detalle`, `id_plan`, `nro_cuota`, `fecha_vencimiento`, `monto_cuota`, `estado`) VALUES
(1, 1, 1, '2025-08-06', 510000, 'PENDIENTE');

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
(1, '2025-08-06', '', 1, 260000, 1, 'APROBADO');

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
(1, 1, 1, 1, 30000),
(2, 1, 2, 2, 25000),
(3, 1, 3, 3, 60000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_servicio_cabecera`
--

CREATE TABLE `presupuesto_servicio_cabecera` (
  `id_presupuesto_servicio` int(11) NOT NULL,
  `id_diagnostico` int(11) NOT NULL,
  `fecha_presupuesto` date NOT NULL DEFAULT curdate(),
  `validez_dias` int(11) NOT NULL DEFAULT 7,
  `estado` varchar(20) NOT NULL DEFAULT 'Enviado',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuesto_servicio_cabecera`
--

INSERT INTO `presupuesto_servicio_cabecera` (`id_presupuesto_servicio`, `id_diagnostico`, `fecha_presupuesto`, `validez_dias`, `estado`, `observaciones`) VALUES
(1, 1, '2025-08-06', 7, 'UTILIZADO', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_servicio_detalle`
--

CREATE TABLE `presupuesto_servicio_detalle` (
  `id_detalle_presu` int(11) NOT NULL,
  `id_presupuesto_servicio` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` int(11) NOT NULL,
  `subtotal` int(11) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `presupuesto_servicio_detalle`
--

INSERT INTO `presupuesto_servicio_detalle` (`id_detalle_presu`, `id_presupuesto_servicio`, `concepto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 'Display', 1, 180000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_venta_cabecera`
--

CREATE TABLE `presupuesto_venta_cabecera` (
  `id_presupuesto_venta` int(11) NOT NULL,
  `nro_presupuesto` varchar(20) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `condicion` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_venta_detalle`
--

CREATE TABLE `presupuesto_venta_detalle` (
  `id_presupuesto_venta_detalle` int(11) NOT NULL,
  `id_presupuesto_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Cargador USB tipo C', 60000, 0, 'ACTIVO', 10),
(2, 'Cargador USB Micro', 50000, 1, 'ACTIVO', 10),
(3, 'Cable USB tipo C', 30000, 3, 'ACTIVO', 10),
(4, 'Cable USB Micro', 25000, 0, 'ACTIVO', 10),
(5, 'Auriculares Bluetooth', 120000, 0, 'ACTIVO', 10),
(6, 'Auriculares con cable', 40000, 0, 'ACTIVO', 10),
(7, 'Vidrio templado universal', 20000, 0, 'ACTIVO', 10),
(8, 'Vidrio templado iPhone', 25000, 0, 'ACTIVO', 10),
(9, 'Funda silicona Samsung', 35000, 0, 'ACTIVO', 10),
(10, 'Funda silicona iPhone', 40000, 1, 'ACTIVO', 10),
(11, 'Batería Samsung A10', 80000, 0, 'ACTIVO', 10),
(12, 'Batería iPhone 7', 150000, 0, 'ACTIVO', 10),
(13, 'Parlante Bluetooth portátil', 180000, 0, 'ACTIVO', 10),
(14, 'Soporte para auto magnético', 50000, 0, 'ACTIVO', 10),
(15, 'Soporte para auto universal', 45000, 0, 'ACTIVO', 10),
(16, 'Cámara frontal Samsung A20', 70000, 0, 'ACTIVO', 10),
(17, 'Cámara trasera Samsung A20', 100000, 0, 'ACTIVO', 10),
(18, 'Memoria MicroSD 32GB', 70000, 0, 'ACTIVO', 10),
(19, 'Memoria MicroSD 64GB', 120000, 0, 'ACTIVO', 10),
(20, 'Power Bank 10000mAh', 150000, 0, 'ACTIVO', 10);

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
(1, 'Accesorios y Repuestos Mobile S.A.', '80012345-6', '0981 123 456', 'ACTIVO'),
(2, 'TecnoParts Importaciones', '80123456-7', '0982 234 567', 'ACTIVO'),
(3, 'Celulares & Más', '80234567-8', '0983 345 678', 'ACTIVO'),
(4, 'Distribuidora SmartTech', '80345678-9', '0984 456 789', 'ACTIVO'),
(5, 'Global Accesorios S.R.L.', '80456789-0', '0985 567 890', 'ACTIVO');

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
(1, '2025-08-06', 1, 3, 'UTILIZADO');

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
(1, 1, 'Display', 'SIN DESCRIPCION', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuesto`
--

CREATE TABLE `repuesto` (
  `id_repuesto` int(11) NOT NULL,
  `nombre_repuesto` varchar(100) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `repuesto`
--

INSERT INTO `repuesto` (`id_repuesto`, `nombre_repuesto`, `precio`, `estado`) VALUES
(1, 'Pantalla Samsung A10', 250000, 'ACTIVO'),
(2, 'Pantalla Samsung A20', 280000, 'ACTIVO'),
(3, 'Pantalla iPhone 7', 320000, 'ACTIVO'),
(4, 'Pantalla iPhone X', 550000, 'ACTIVO'),
(5, 'Batería Samsung A10', 80000, 'ACTIVO'),
(6, 'Batería iPhone 7', 150000, 'ACTIVO'),
(7, 'Flex de carga Samsung A20', 50000, 'ACTIVO'),
(8, 'Flex de carga iPhone 8', 70000, 'ACTIVO'),
(9, 'Altavoz interno iPhone 7', 60000, 'ACTIVO'),
(10, 'Cámara trasera Samsung A30', 120000, 'ACTIVO');

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
-- Estructura de tabla para la tabla `servicio_cabecera`
--

CREATE TABLE `servicio_cabecera` (
  `id_servicio` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `fecha_inicio` date NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'En Proceso',
  `observaciones` text DEFAULT NULL,
  `total_general` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_cabecera`
--

INSERT INTO `servicio_cabecera` (`id_servicio`, `id_presupuesto`, `id_tecnico`, `fecha_inicio`, `fecha_fin`, `estado`, `observaciones`, `total_general`) VALUES
(1, 1, 1, '2025-08-06', '2025-08-06', 'En Proceso', '', 180000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_detalle`
--

CREATE TABLE `servicio_detalle` (
  `id_detalle_srv` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `tarea` varchar(100) NOT NULL,
  `horas_trabajadas` int(11) NOT NULL DEFAULT 0,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_detalle`
--

INSERT INTO `servicio_detalle` (`id_detalle_srv`, `id_servicio`, `tarea`, `horas_trabajadas`, `observaciones`) VALUES
(1, 1, 'Cambio', 0, 'SIN OBS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_entrega`
--

CREATE TABLE `servicio_entrega` (
  `id_entrega` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `monto_servicio` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'PENDIENTE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_entrega`
--

INSERT INTO `servicio_entrega` (`id_entrega`, `id_servicio`, `fecha_entrega`, `id_usuario`, `monto_servicio`, `estado`) VALUES
(1, 1, '2025-08-06', 1, 180000, 'PAGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_entrega_pago`
--

CREATE TABLE `servicio_entrega_pago` (
  `id_pago` int(11) NOT NULL,
  `id_entrega` int(11) NOT NULL,
  `tipo_pago` varchar(50) NOT NULL,
  `monto` int(11) NOT NULL,
  `fecha_pago` datetime NOT NULL DEFAULT current_timestamp(),
  `id_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_entrega_pago`
--

INSERT INTO `servicio_entrega_pago` (`id_pago`, `id_entrega`, `tipo_pago`, `monto`, `fecha_pago`, `id_registro`) VALUES
(1, 1, 'Efectivo', 180000, '2025-08-06 13:52:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_garantia`
--

CREATE TABLE `servicio_garantia` (
  `id_garantia` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL DEFAULT curdate(),
  `duracion_dias` int(11) NOT NULL DEFAULT 30,
  `estado` varchar(20) NOT NULL DEFAULT 'Vigente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_garantia`
--

INSERT INTO `servicio_garantia` (`id_garantia`, `id_servicio`, `fecha_inicio`, `duracion_dias`, `estado`) VALUES
(1, 1, '2025-08-06', 30, 'Vigente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_repuesto`
--

CREATE TABLE `servicio_repuesto` (
  `id_srv_rep` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `id_repuesto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Carlos López', '4.123.456', '0981 111 111', 'ACTIVO'),
(2, 'María González', '3.987.654', '0982 222 222', 'ACTIVO'),
(3, 'Jorge Fernández', '2.345.678', '0983 333 333', 'ACTIVO'),
(4, 'Lucía Martínez', '5.678.901', '0984 444 444', 'ACTIVO'),
(5, 'Pedro Ramírez', '1.234.567', '0985 555 555', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `id_cargo`, `id_permiso`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 1, 1),
(2, 'leandro', '202cb962ac59075b964b07152d234b70', 2, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id_auditoria`);

--
-- Indices de la tabla `caja_registro`
--
ALTER TABLE `caja_registro`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

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
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_compra_detalle_cabecera` (`id_compra`),
  ADD KEY `fk_compra_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `diagnostico_cabecera`
--
ALTER TABLE `diagnostico_cabecera`
  ADD PRIMARY KEY (`id_diagnostico`),
  ADD KEY `fk_diag_recep` (`id_recepcion_cabecera`);

--
-- Indices de la tabla `diagnostico_detalle`
--
ALTER TABLE `diagnostico_detalle`
  ADD PRIMARY KEY (`id_diagnostico_detalle`),
  ADD KEY `fk_det_diag` (`id_diagnostico`);

--
-- Indices de la tabla `entrada_productos_cabecera`
--
ALTER TABLE `entrada_productos_cabecera`
  ADD PRIMARY KEY (`id_entrada`);

--
-- Indices de la tabla `entrada_salida_detalle`
--
ALTER TABLE `entrada_salida_detalle`
  ADD PRIMARY KEY (`id_entrada_detalle`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id_equipo`);

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
  ADD PRIMARY KEY (`id_orden`);

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
  ADD KEY `fk_pedido_proveedor_cabecera_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `pedido_proveedor_detalle`
--
ALTER TABLE `pedido_proveedor_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_pedido_proveedor_detalle_cabecera` (`id_pedido`),
  ADD KEY `fk_pedido_proveedor_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `plan_pago_cabecera`
--
ALTER TABLE `plan_pago_cabecera`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `fk_plan_factura` (`id_factura_cabecera`);

--
-- Indices de la tabla `plan_pago_detalle`
--
ALTER TABLE `plan_pago_detalle`
  ADD PRIMARY KEY (`id_plan_detalle`),
  ADD KEY `fk_plan_detalle_cabecera` (`id_plan`);

--
-- Indices de la tabla `presupuesto_cabecera`
--
ALTER TABLE `presupuesto_cabecera`
  ADD PRIMARY KEY (`id_presupuesto`);

--
-- Indices de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_presupuesto1` (`id_presupuesto`),
  ADD KEY `fk_detalle_producto1` (`id_producto`);

--
-- Indices de la tabla `presupuesto_servicio_cabecera`
--
ALTER TABLE `presupuesto_servicio_cabecera`
  ADD PRIMARY KEY (`id_presupuesto_servicio`),
  ADD KEY `fk_presu_diag` (`id_diagnostico`);

--
-- Indices de la tabla `presupuesto_servicio_detalle`
--
ALTER TABLE `presupuesto_servicio_detalle`
  ADD PRIMARY KEY (`id_detalle_presu`);

--
-- Indices de la tabla `presupuesto_venta_cabecera`
--
ALTER TABLE `presupuesto_venta_cabecera`
  ADD PRIMARY KEY (`id_presupuesto_venta`),
  ADD KEY `fk_presupuesto_venta_cliente` (`id_cliente`);

--
-- Indices de la tabla `presupuesto_venta_detalle`
--
ALTER TABLE `presupuesto_venta_detalle`
  ADD PRIMARY KEY (`id_presupuesto_venta_detalle`),
  ADD KEY `fk_presupuesto_venta_cabecera` (`id_presupuesto_venta`),
  ADD KEY `fk_presupuesto_venta_producto` (`id_producto`);

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
-- Indices de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  ADD PRIMARY KEY (`id_repuesto`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `servicio_cabecera`
--
ALTER TABLE `servicio_cabecera`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `fk_srv_presu` (`id_presupuesto`);

--
-- Indices de la tabla `servicio_detalle`
--
ALTER TABLE `servicio_detalle`
  ADD PRIMARY KEY (`id_detalle_srv`),
  ADD KEY `fk_det_srv` (`id_servicio`);

--
-- Indices de la tabla `servicio_entrega`
--
ALTER TABLE `servicio_entrega`
  ADD PRIMARY KEY (`id_entrega`),
  ADD KEY `fk_ent_srv` (`id_servicio`);

--
-- Indices de la tabla `servicio_entrega_pago`
--
ALTER TABLE `servicio_entrega_pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_ent` (`id_entrega`);

--
-- Indices de la tabla `servicio_garantia`
--
ALTER TABLE `servicio_garantia`
  ADD PRIMARY KEY (`id_garantia`),
  ADD KEY `fk_gar_srv` (`id_servicio`);

--
-- Indices de la tabla `servicio_repuesto`
--
ALTER TABLE `servicio_repuesto`
  ADD PRIMARY KEY (`id_srv_rep`),
  ADD KEY `fk_srvrep_srv` (`id_servicio`);

--
-- Indices de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id_tecnico`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `caja_registro`
--
ALTER TABLE `caja_registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente_equipo`
--
ALTER TABLE `cliente_equipo`
  MODIFY `id_cliente_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra_cabecera`
--
ALTER TABLE `compra_cabecera`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `diagnostico_cabecera`
--
ALTER TABLE `diagnostico_cabecera`
  MODIFY `id_diagnostico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `diagnostico_detalle`
--
ALTER TABLE `diagnostico_detalle`
  MODIFY `id_diagnostico_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entrada_productos_cabecera`
--
ALTER TABLE `entrada_productos_cabecera`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrada_salida_detalle`
--
ALTER TABLE `entrada_salida_detalle`
  MODIFY `id_entrada_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `factura_cabecera`
--
ALTER TABLE `factura_cabecera`
  MODIFY `id_factura_cabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `id_factura_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedido_proveedor_cabecera`
--
ALTER TABLE `pedido_proveedor_cabecera`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido_proveedor_detalle`
--
ALTER TABLE `pedido_proveedor_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `plan_pago_cabecera`
--
ALTER TABLE `plan_pago_cabecera`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `plan_pago_detalle`
--
ALTER TABLE `plan_pago_detalle`
  MODIFY `id_plan_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuesto_cabecera`
--
ALTER TABLE `presupuesto_cabecera`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `presupuesto_servicio_cabecera`
--
ALTER TABLE `presupuesto_servicio_cabecera`
  MODIFY `id_presupuesto_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuesto_servicio_detalle`
--
ALTER TABLE `presupuesto_servicio_detalle`
  MODIFY `id_detalle_presu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presupuesto_venta_cabecera`
--
ALTER TABLE `presupuesto_venta_cabecera`
  MODIFY `id_presupuesto_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuesto_venta_detalle`
--
ALTER TABLE `presupuesto_venta_detalle`
  MODIFY `id_presupuesto_venta_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recepcion_cabecera`
--
ALTER TABLE `recepcion_cabecera`
  MODIFY `id_recepcion_cabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `recepcion_detalle`
--
ALTER TABLE `recepcion_detalle`
  MODIFY `id_recepcion_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  MODIFY `id_repuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicio_cabecera`
--
ALTER TABLE `servicio_cabecera`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicio_detalle`
--
ALTER TABLE `servicio_detalle`
  MODIFY `id_detalle_srv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicio_entrega`
--
ALTER TABLE `servicio_entrega`
  MODIFY `id_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicio_entrega_pago`
--
ALTER TABLE `servicio_entrega_pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicio_garantia`
--
ALTER TABLE `servicio_garantia`
  MODIFY `id_garantia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicio_repuesto`
--
ALTER TABLE `servicio_repuesto`
  MODIFY `id_srv_rep` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  MODIFY `id_tecnico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `diagnostico_cabecera`
--
ALTER TABLE `diagnostico_cabecera`
  ADD CONSTRAINT `fk_diag_recep` FOREIGN KEY (`id_recepcion_cabecera`) REFERENCES `recepcion_cabecera` (`id_recepcion_cabecera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `diagnostico_detalle`
--
ALTER TABLE `diagnostico_detalle`
  ADD CONSTRAINT `fk_det_diag` FOREIGN KEY (`id_diagnostico`) REFERENCES `diagnostico_cabecera` (`id_diagnostico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `presupuesto_servicio_cabecera`
--
ALTER TABLE `presupuesto_servicio_cabecera`
  ADD CONSTRAINT `fk_presu_diag` FOREIGN KEY (`id_diagnostico`) REFERENCES `diagnostico_cabecera` (`id_diagnostico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_entrega`
--
ALTER TABLE `servicio_entrega`
  ADD CONSTRAINT `fk_ent_srv` FOREIGN KEY (`id_servicio`) REFERENCES `servicio_cabecera` (`id_servicio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_entrega_pago`
--
ALTER TABLE `servicio_entrega_pago`
  ADD CONSTRAINT `fk_pago_ent` FOREIGN KEY (`id_entrega`) REFERENCES `servicio_entrega` (`id_entrega`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_garantia`
--
ALTER TABLE `servicio_garantia`
  ADD CONSTRAINT `fk_gar_srv` FOREIGN KEY (`id_servicio`) REFERENCES `servicio_cabecera` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_repuesto`
--
ALTER TABLE `servicio_repuesto`
  ADD CONSTRAINT `fk_srvrep_srv` FOREIGN KEY (`id_servicio`) REFERENCES `servicio_cabecera` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
