-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2020 a las 16:26:10
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sc_meeting`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogos`
--

CREATE TABLE `catalogos` (
  `catalogotipo` int(11) NOT NULL,
  `catalogotiponombre` varchar(25) DEFAULT NULL,
  `catalogovalor` varchar(10) NOT NULL,
  `catalogovalornombre` varchar(25) DEFAULT NULL,
  `catalogovalordescripcion` varchar(50) DEFAULT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `catalogos`
--

INSERT INTO `catalogos` (`catalogotipo`, `catalogotiponombre`, `catalogovalor`, `catalogovalornombre`, `catalogovalordescripcion`, `estado`) VALUES
(1, 'MEETINGS STATUS', 'AGE', 'AGENDADO', 'AGENDADO', '1'),
(1, 'MEETINGS STATUS', 'CAN', 'CANCELADO', 'CANCELADO', '1'),
(1, 'MEETINGS STATUS', 'INI', 'INICIO', 'INICIO', '1'),
(1, 'MEETINGS STATUS', 'REG', 'REGISTRADO', 'REGISTRADO', '1'),
(2, 'MEETINGS ACTIONS', 'AGEPRO', 'AGENDAR', 'AGENDAR PROFESOR', '1'),
(2, 'MEETINGS ACTIONS', 'CANEST', 'CANCELAR', 'CANCELAR ESTUDIANTE', '1'),
(2, 'MEETINGS ACTIONS', 'CANPRO', 'CANCELAR', 'CANCELAR PROFESOR', '1'),
(2, 'MEETINGS ACTIONS', 'REGEST', 'REGISTRAR', 'REGISTRAR ESTUDIANTE', '1'),
(3, 'TYPE USER', 'EST', 'ESTUDIANTE', 'ESTUDIANTE', '1'),
(3, 'TYPE USER', 'PRO', 'PROFESOR', 'PROFESOR', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `estudianteid` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `curso` int(11) NOT NULL,
  `paralelo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`estudianteid`, `nombres`, `cedula`, `email`, `estado`, `curso`, `paralelo`) VALUES
(1, 'Alex Caiza', '1002556437', 'araul_ar@gmail.com', '1', 8, 'A'),
(2, 'Critina Montenegro', '1003001375', 'maricris@gmail.com', '1', 9, 'B'),
(4, 'Luis Salazar', '101', 'a@a.com', '1', 8, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `horaid` int(11) NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horas`
--

INSERT INTO `horas` (`horaid`, `horainicio`, `horafin`, `estado`) VALUES
(1, '10:00:00', '10:20:00', '1'),
(2, '10:20:00', '10:40:00', '1'),
(3, '10:40:00', '11:00:00', '1'),
(4, '11:00:00', '11:20:00', '1'),
(5, '11:20:00', '11:40:00', '1'),
(6, '11:40:00', '12:00:00', '1'),
(7, '12:00:00', '12:20:00', '1'),
(8, '12:20:00', '12:40:00', '1'),
(9, '12:40:00', '13:00:00', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meetings`
--

CREATE TABLE `meetings` (
  `meetingid` int(11) NOT NULL,
  `profesorid` int(11) NOT NULL,
  `estudianteid` int(11) NOT NULL,
  `fechameeting` date NOT NULL,
  `horaid` int(11) NOT NULL,
  `meetingurl` varchar(200) DEFAULT NULL,
  `meetingstatuscode` int(11) NOT NULL,
  `meetingstatusvalue` varchar(10) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `fecharegistro` timestamp NULL DEFAULT NULL,
  `usuarioregistro` varchar(20) DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `usuariomodificacion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `meetings`
--

INSERT INTO `meetings` (`meetingid`, `profesorid`, `estudianteid`, `fechameeting`, `horaid`, `meetingurl`, `meetingstatuscode`, `meetingstatusvalue`, `estado`, `fecharegistro`, `usuarioregistro`, `fechamodificacion`, `usuariomodificacion`) VALUES
(48, 1, 4, '2020-11-09', 1, NULL, 1, 'CAN', '1', '2020-11-09 21:14:25', NULL, '2020-11-09 21:14:48', NULL),
(49, 1, 4, '2020-11-10', 1, NULL, 1, 'CAN', '1', '2020-11-09 21:16:09', NULL, '2020-11-09 21:16:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meetingsenginestatus`
--

CREATE TABLE `meetingsenginestatus` (
  `estadoanteriortipo` int(11) NOT NULL,
  `estadoanteriorvalor` varchar(10) NOT NULL,
  `estadoactualtipo` int(11) NOT NULL,
  `estadoactualvalor` varchar(10) NOT NULL,
  `estadoacciontipo` int(11) NOT NULL,
  `estadoaccionvalor` varchar(10) NOT NULL,
  `codigotipousuario` int(11) DEFAULT NULL,
  `valortipousuario` varchar(10) DEFAULT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `meetingsenginestatus`
--

INSERT INTO `meetingsenginestatus` (`estadoanteriortipo`, `estadoanteriorvalor`, `estadoactualtipo`, `estadoactualvalor`, `estadoacciontipo`, `estadoaccionvalor`, `codigotipousuario`, `valortipousuario`, `estado`) VALUES
(1, 'INI', 1, 'REG', 2, 'REGEST', 3, 'EST', '1'),
(1, 'REG', 1, 'AGE', 2, 'AGEPRO', 3, 'PRO', '1'),
(1, 'REG', 1, 'CAN', 2, 'CANEST', 3, 'EST', '1'),
(1, 'REG', 1, 'CAN', 2, 'CANPRO', 3, 'PRO', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meetingsstatus`
--

CREATE TABLE `meetingsstatus` (
  `meetingsstatusid` int(11) NOT NULL,
  `meetingid` int(11) NOT NULL,
  `estadoanteriortipo` int(11) DEFAULT NULL,
  `estadoanteriorvalor` varchar(10) DEFAULT NULL,
  `estadoactualtipo` int(11) DEFAULT NULL,
  `estadoactualvalor` varchar(10) DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `fecharegistro` timestamp NULL DEFAULT NULL,
  `fechamodificacion` timestamp NULL DEFAULT NULL,
  `estado` varchar(1) NOT NULL,
  `observacion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `meetingsstatus`
--

INSERT INTO `meetingsstatus` (`meetingsstatusid`, `meetingid`, `estadoanteriortipo`, `estadoanteriorvalor`, `estadoactualtipo`, `estadoactualvalor`, `fechainicio`, `fechafin`, `fecharegistro`, `fechamodificacion`, `estado`, `observacion`) VALUES
(39, 48, 1, 'INI', 1, 'REG', '2020-11-09 21:14:25', '2020-11-09 21:14:48', '2020-11-09 21:14:25', '2020-11-09 21:14:48', '1', NULL),
(40, 48, 1, 'REG', 1, 'CAN', '2020-11-09 21:14:48', NULL, '2020-11-09 21:14:48', NULL, '1', 'afdafdsfadsf'),
(41, 49, 1, 'INI', 1, 'REG', '2020-11-09 21:16:09', '2020-11-09 21:16:18', '2020-11-09 21:16:09', '2020-11-09 21:16:18', '1', NULL),
(42, 49, 1, 'REG', 1, 'CAN', '2020-11-09 21:16:18', NULL, '2020-11-09 21:16:18', NULL, '1', 'fasdfasdfas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `profesorid` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`profesorid`, `cedula`, `email`, `nombres`, `estado`) VALUES
(1, '100', 'a@a.com', 'MARILU ABAD', '1'),
(2, '1001001002', 'bbb@gmail.com', 'KARINA ARROLLO', '1'),
(3, '1001001003', 'ccc@gmail.com', 'SOLEDAD VALENZUELA ', '1'),
(4, '', '', 'MAGDA CRUZ', '1'),
(5, '', '', 'MARCOS HIDALGO', '1'),
(6, '', '', 'ERICK DOMINGUEZ', '1'),
(7, '', '', 'JAIRO SAA', '1'),
(8, '', '', 'CRISTIAN MURILLO', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogos`
--
ALTER TABLE `catalogos`
  ADD PRIMARY KEY (`catalogotipo`,`catalogovalor`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`estudianteid`);

--
-- Indices de la tabla `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`horaid`);

--
-- Indices de la tabla `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meetingid`);

--
-- Indices de la tabla `meetingsenginestatus`
--
ALTER TABLE `meetingsenginestatus`
  ADD PRIMARY KEY (`estadoanteriortipo`,`estadoanteriorvalor`,`estadoactualtipo`,`estadoactualvalor`,`estadoacciontipo`,`estadoaccionvalor`) USING BTREE;

--
-- Indices de la tabla `meetingsstatus`
--
ALTER TABLE `meetingsstatus`
  ADD PRIMARY KEY (`meetingsstatusid`),
  ADD KEY `meetingid` (`meetingid`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`profesorid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `estudianteid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `horaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `meetings`
--
ALTER TABLE `meetings`
  MODIFY `meetingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `meetingsstatus`
--
ALTER TABLE `meetingsstatus`
  MODIFY `meetingsstatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `profesorid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `meetingsstatus`
--
ALTER TABLE `meetingsstatus`
  ADD CONSTRAINT `meetingsstatus_ibfk_1` FOREIGN KEY (`meetingid`) REFERENCES `meetings` (`meetingid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
