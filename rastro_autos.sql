-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-07-2025 a las 08:41:08
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rastro_autos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rol` varchar(50) DEFAULT 'cliente',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `correo`, `usuario`, `password`, `fecha_registro`, `rol`, `creado_en`) VALUES
(1, 'armando Puertas', 'puertas@gmail.com', 'puerta', '$2y$10$PI3/LLncQwNX2mpeuv58jOdyTw3ODqxn.tPWP5m9FpcTcV5V5y1ou', '2025-07-21 03:29:45', 'cliente', '2025-07-21 03:29:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_partes`
--

DROP TABLE IF EXISTS `inventario_partes`;
CREATE TABLE IF NOT EXISTS `inventario_partes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_parte` varchar(100) NOT NULL,
  `marca_auto` varchar(50) NOT NULL,
  `modelo_auto` varchar(100) DEFAULT NULL,
  `anio` int NOT NULL,
  `descripcion` text,
  `costo` decimal(10,2) NOT NULL,
  `unidades` int NOT NULL DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `imagen` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventario_partes`
--

INSERT INTO `inventario_partes` (`id`, `nombre_parte`, `marca_auto`, `modelo_auto`, `anio`, `descripcion`, `costo`, `unidades`, `activo`, `imagen`, `creado_en`) VALUES
(2, 'Emblema de Honda Rojo', 'Honda', 'Civic', 2016, 'Embleda de Honda Civic color Rojo ver.15423', 150.00, 50, 0, 'img/6873fa217b961_embelema civic.jpg', '2025-07-13 18:25:37'),
(3, 'Emblema de Honda Rojo', 'Honda', 'Civic', 2015, 'logo de honda civi color negro. seria 12ges12341', 60.00, 50, 0, 'img/68765ba75f870_honda logo.jpg', '2025-07-15 13:46:15'),
(4, 'Arrancador', 'Ford', 'Mustang', 2025, 'arrancador ford mustang edicion platinum 1e25123', 1000.00, 32, 1, 'img/687c1169c6a4c_ARRANCADLR FORD E25F-12312.jpg', '2025-07-19 21:43:05'),
(11, 'amortiguador', 'Honda', 'Civic', 2020, 'amortiguador honda', 2000.00, 19, 1, 'img/687deb97cc1dc_amortiguador honda.jpg', '2025-07-21 07:26:15'),
(8, 'bujia', 'Ford', 'Mustang', 2015, 'bujia ford mustang 1sg12345', 1233.00, 12, 1, 'img/687ddcddb4404_bujia de ford mustang.jpg', '2025-07-21 06:23:25'),
(10, 'hjgh', 'Toyota', 'Corolla', 567, '56756j7htggyu', 56755.00, 67567, 1, 'img/687de7aa1c1fa_rin de toyota hilux.jpg', '2025-07-21 07:09:30'),
(12, 'Rin silv', 'Chevrolet', 'Silverado', 20252, 'rin para el silverado', 2130.00, 32, 0, 'img/687debd710bb2_rin de toyota hilux.jpg', '2025-07-21 07:27:19'),
(13, 'aleron deportivo', 'Ford', 'Mustang', 2025, 'aleron deportivo de fibra de carbon color nrego 1FC001', 1500.00, 64, 1, 'img/687ded1953a64_aleron ford mustang.jpg', '2025-07-21 07:32:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','empleado') NOT NULL,
  `permisos` json DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`, `permisos`, `creado_en`) VALUES
(3, 'Administrador General', 'admin', '$2y$10$MG/moDHeMzlg3QjKBYuLbuLXMW43Kh2ljkvt1lBeDHGN4qZY57Qnu', 'admin', '{\"usuarios\": true, \"secciones\": true, \"inventario\": true, \"movimientos\": true}', '2025-07-09 14:25:07'),
(8, '', 'COCO', '$2y$10$JhiZ1/nmoA1ZwM5ou9n71uzdJSQtXyXTNNHxRYcNsEHrq0u5mE7/.', 'empleado', '{\"inventario\": true}', '2025-07-20 20:53:02'),
(10, '', 'carnita', '$2y$10$pnl2WXpl8vRmPqJUrLngZu9nXoFqN.R4CHwcvP27DmoLahjtuuOwC', 'admin', '{\"inventario\": true, \"movimientos\": true}', '2025-07-21 07:47:37'),
(9, '', 'colchon', '$2y$10$0szPUnQyWDkcIYJq2rM9IuvuaEoaVLCmVCOzNJG3bJ2o05iZDn1Aq', 'empleado', '{\"secciones\": true, \"movimientos\": true}', '2025-07-21 06:03:13'),
(11, '', 'cara', '$2y$10$IOiwNOp/GCvSPZ0RznvoKucDsoeIU2lsx.5ifHBVs4H4YDhcCFJwq', 'empleado', '{\"usuarios\": true, \"secciones\": true, \"inventario\": true}', '2025-07-21 08:29:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
