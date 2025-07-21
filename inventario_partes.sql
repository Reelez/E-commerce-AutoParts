-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-07-2025 a las 04:21:45
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventario_partes`
--

INSERT INTO `inventario_partes` (`id`, `nombre_parte`, `marca_auto`, `modelo_auto`, `anio`, `descripcion`, `costo`, `unidades`, `activo`, `imagen`, `creado_en`) VALUES
(2, 'Emblema de Honda Rojo', 'Honda', 'Civic', 2016, 'Embleda de Honda Civic color Rojo ver.15423', 150.00, 50, 1, 'img/6873fa217b961_embelema civic.jpg', '2025-07-13 18:25:37'),
(3, 'Emblema de Honda Rojo', 'Honda', 'Civic', 2015, 'logo de honda civi color negro. seria 12ges12341', 60.00, 50, 1, 'img/68765ba75f870_honda logo.jpg', '2025-07-15 13:46:15'),
(4, 'Arrancador', 'Ford', 'Mustang', 2025, 'arrancador ford mustang edicion platinum 1e25123', 1000.00, 32, 1, 'img/687c1169c6a4c_ARRANCADLR FORD E25F-12312.jpg', '2025-07-19 21:43:05');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
