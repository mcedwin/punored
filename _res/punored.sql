-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 17-02-2022 a las 21:13:16
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `punored`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

DROP TABLE IF EXISTS `anuncio`;
CREATE TABLE IF NOT EXISTS `anuncio` (
  `anun_id` int(11) NOT NULL AUTO_INCREMENT,
  `anun_usua_id` int(11) DEFAULT NULL,
  `anun_cate_id` int(11) DEFAULT NULL,
  `anun_titulo` varchar(45) DEFAULT NULL,
  `anun_descripcion` text,
  `anun_foto` varchar(45) DEFAULT NULL,
  `anun_url` varchar(145) DEFAULT NULL,
  `anun_fechareg` datetime DEFAULT NULL,
  `anun_fechapub` datetime DEFAULT NULL,
  `anun_fechaven` datetime DEFAULT NULL,
  `anun_espublico` bit(1) DEFAULT NULL,
  PRIMARY KEY (`anun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio_categoria`
--

DROP TABLE IF EXISTS `anuncio_categoria`;
CREATE TABLE IF NOT EXISTS `anuncio_categoria` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directorio`
--

DROP TABLE IF EXISTS `directorio`;
CREATE TABLE IF NOT EXISTS `directorio` (
  `dire_id` int(11) NOT NULL AUTO_INCREMENT,
  `dire_nombre` varchar(150) DEFAULT NULL,
  `dire_resumen` varchar(255) DEFAULT NULL,
  `dire_contenido` text,
  `dire_pmas` int(11) DEFAULT NULL,
  `dire_pmenos` int(11) DEFAULT NULL,
  `dire_logo` varchar(45) DEFAULT NULL,
  `dire_imagen` varchar(45) DEFAULT NULL,
  `dire_cate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`dire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directorio_categoria`
--

DROP TABLE IF EXISTS `directorio_categoria`;
CREATE TABLE IF NOT EXISTS `directorio_categoria` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
CREATE TABLE IF NOT EXISTS `encuesta` (
  `encu_id` int(11) NOT NULL AUTO_INCREMENT,
  `encu_titulo` varchar(150) DEFAULT NULL,
  `encu_descripcion` varchar(255) DEFAULT NULL,
  `encu_foto` varchar(45) DEFAULT NULL,
  `encu_usua_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`encu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta_detalle`
--

DROP TABLE IF EXISTS `encuesta_detalle`;
CREATE TABLE IF NOT EXISTS `encuesta_detalle` (
  `deta_id` int(11) NOT NULL AUTO_INCREMENT,
  `deta_encu_id` int(11) DEFAULT NULL,
  `deta_alternativa` varchar(150) DEFAULT NULL,
  `deta_puntos` int(11) DEFAULT NULL,
  PRIMARY KEY (`deta_id`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

DROP TABLE IF EXISTS `entrada`;
CREATE TABLE IF NOT EXISTS `entrada` (
  `entr_id` int(11) NOT NULL AUTO_INCREMENT,
  `entr_usua_id` int(11) DEFAULT NULL,
  `entr_titulo` varchar(150) DEFAULT NULL,
  `entr_descripcion` text,
  `entr_foto` varchar(45) DEFAULT NULL,
  `entr_url` varchar(150) DEFAULT NULL,
  `entr_area_id` int(11) DEFAULT NULL,
  `entr_fechareg` datetime DEFAULT NULL,
  `entr_fechapub` datetime DEFAULT NULL,
  `entr_espublico` bit(1) NOT NULL DEFAULT b'1',
  `entr_pmas` int(11) NOT NULL DEFAULT '0',
  `entr_pmenos` int(11) NOT NULL DEFAULT '0',
  `entr_cate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`entr_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_categoria`
--

DROP TABLE IF EXISTS `entrada_categoria`;
CREATE TABLE IF NOT EXISTS `entrada_categoria` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `entrada_categoria`
--

INSERT INTO `entrada_categoria` (`cate_id`, `cate_nombre`) VALUES
(1, 'dfsdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE IF NOT EXISTS `incidencia` (
  `inci_id` int(11) NOT NULL AUTO_INCREMENT,
  `inci_titulo` varchar(45) DEFAULT NULL,
  `inci_descripcion` text,
  `inci_foto` varchar(45) DEFAULT NULL,
  `inci_latitude` varchar(45) DEFAULT NULL,
  `inci_longitude` varchar(45) DEFAULT NULL,
  `inci_pmas` int(11) DEFAULT NULL,
  `inci_pmenos` int(11) DEFAULT NULL,
  `inci_espublico` bit(1) DEFAULT NULL,
  `inci_cate_id` int(11) DEFAULT NULL,
  `inci_usua_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`inci_id`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia_categoria`
--

DROP TABLE IF EXISTS `incidencia_categoria`;
CREATE TABLE IF NOT EXISTS `incidencia_categoria` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usua_id` int(11) NOT NULL AUTO_INCREMENT,
  `usua_nombres` varchar(45) DEFAULT NULL,
  `usua_movil` varchar(45) DEFAULT NULL,
  `usua_email` varchar(45) DEFAULT NULL,
  `usua_password` varchar(45) DEFAULT NULL,
  `usua_foto` varchar(45) DEFAULT NULL,
  `usua_descripcion` text,
  `usua_password2` varchar(45) DEFAULT NULL,
  `usua_activo` bit(1) NOT NULL DEFAULT b'1',
  `usua_tipo_id` int(11) DEFAULT NULL,
  `usua_lastip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`usua_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usua_id`, `usua_nombres`, `usua_movil`, `usua_email`, `usua_password`, `usua_foto`, `usua_descripcion`, `usua_password2`, `usua_activo`, `usua_tipo_id`, `usua_lastip`) VALUES
(6, 'gfh', NULL, 'fgh@sdfsdf.com', '0f98df87c7440c045496f705c7295344', NULL, NULL, '4d788c035477d1736a1c19c887670925', b'1', 1, NULL),
(7, 'ert', NULL, 'ertert', 'e3e84538a1b02b1cc11bf71fe3169958', NULL, NULL, '63d79f99724dfe7bd44e05138f29c2be', b'1', 1, NULL),
(8, 'ert', NULL, 'ertertdsf', 'e3e84538a1b02b1cc11bf71fe3169958', NULL, NULL, '52a0bf0a57bb2a360c59f2b75d7e77db', b'1', 1, NULL),
(9, 'sdfsdf', NULL, 'sdfsdf', 'd9729feb74992cc3482b350163a1a010', NULL, NULL, 'aa3c7e186b972517fc625b38e3e58e80', b'1', 1, NULL),
(10, 'dsfsdf', NULL, 'sdfsdfss', 'd9729feb74992cc3482b350163a1a010', NULL, NULL, '357b9e04168658f1e06f4ed83419a784', b'1', 1, NULL),
(11, 'Edwin', NULL, 'mcedwin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '5c0b92d1eff1f9a066f204e31c36ae96', b'1', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_encuesta`
--

DROP TABLE IF EXISTS `usuario_encuesta`;
CREATE TABLE IF NOT EXISTS `usuario_encuesta` (
  `rela_id` int(11) NOT NULL,
  `rela_usua_id` int(11) DEFAULT NULL,
  `rela_encu_id` int(11) DEFAULT NULL,
  `rela_fechareg` datetime DEFAULT NULL,
  PRIMARY KEY (`rela_id`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_entrada`
--

DROP TABLE IF EXISTS `usuario_entrada`;
CREATE TABLE IF NOT EXISTS `usuario_entrada` (
  `rela_id` int(11) NOT NULL AUTO_INCREMENT,
  `rela_usua_id` int(11) DEFAULT NULL,
  `rela_entr_id` int(11) DEFAULT NULL,
  `rela_nmas` int(11) NOT NULL DEFAULT '0',
  `rela_nmenos` int(11) NOT NULL DEFAULT '0',
  `rela_like` bit(1) NOT NULL DEFAULT b'0',
  `rela_fechareg` datetime DEFAULT NULL,
  PRIMARY KEY (`rela_id`) USING BTREE,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tipo`
--

DROP TABLE IF EXISTS `usuario_tipo`;
CREATE TABLE IF NOT EXISTS `usuario_tipo` (
  `tipo_id` int(11) NOT NULL,
  `tipo_nombre` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`tipo_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `fk_anuncio_anuncio_categoria1` FOREIGN KEY (`anun_cate_id`) REFERENCES `anuncio_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_anuncio_usuario1` FOREIGN KEY (`anun_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `directorio`
--
ALTER TABLE `directorio`
  ADD CONSTRAINT `fk_directorio_directorio_categoria1` FOREIGN KEY (`dire_cate_id`) REFERENCES `directorio_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `encuesta_detalle`
--
ALTER TABLE `encuesta_detalle`
  ADD CONSTRAINT `fk_encuesta_detalle_encuesta1` FOREIGN KEY (`deta_encu_id`) REFERENCES `encuesta` (`encu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_incidencia_tegoria1` FOREIGN KEY (`inci_cate_id`) REFERENCES `incidencia_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_usuario1` FOREIGN KEY (`inci_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_encuesta`
--
ALTER TABLE `usuario_encuesta`
  ADD CONSTRAINT `fk_usuario_encuesta_encuesta1` FOREIGN KEY (`rela_encu_id`) REFERENCES `encuesta` (`encu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_encuesta_usuario1` FOREIGN KEY (`rela_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_entrada`
--
ALTER TABLE `usuario_entrada`
  ADD CONSTRAINT `fk_usuario_entrada_entrada1` FOREIGN KEY (`rela_entr_id`) REFERENCES `entrada` (`entr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_entrada_usuario1` FOREIGN KEY (`rela_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
