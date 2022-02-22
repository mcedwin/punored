-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-02-2022 a las 14:23:50
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
-- Estructura de tabla para la tabla `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
CREATE TABLE IF NOT EXISTS `encuesta` (
  `encu_id` int(11) NOT NULL AUTO_INCREMENT,
  `encu_titulo` varchar(150) DEFAULT NULL,
  `encu_descripcion` varchar(255) DEFAULT NULL,
  `encu_foto` varchar(45) DEFAULT NULL,
  `encu_usua_id` int(11) DEFAULT NULL,
  `encu_actual` bit(1) DEFAULT NULL,
  PRIMARY KEY (`encu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`encu_id`, `encu_titulo`, `encu_descripcion`, `encu_foto`, `encu_usua_id`, `encu_actual`) VALUES
(1, '¿Cuál de los siguientes ciudadanos cree usted que podría ser el futuro gobernador de la región Puno?', NULL, 'img_1.jpg', NULL, b'1');

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
  KEY `fk_encuesta_detalle_encuesta1_idx` (`deta_encu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta_detalle`
--

INSERT INTO `encuesta_detalle` (`deta_id`, `deta_encu_id`, `deta_alternativa`, `deta_puntos`) VALUES
(1, 1, 'Alexander Flores Pari', 10),
(2, 1, 'Richard Hancco Soncco', 2),
(3, 1, 'Wilber Cutipa Alejo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

DROP TABLE IF EXISTS `entrada`;
CREATE TABLE IF NOT EXISTS `entrada` (
  `entr_id` int(11) NOT NULL AUTO_INCREMENT,
  `entr_tipo_id` int(11) DEFAULT NULL,
  `entr_usua_id` int(11) DEFAULT NULL,
  `entr_titulo` varchar(150) DEFAULT NULL,
  `entr_resumen` varchar(255) DEFAULT NULL,
  `entr_contenido` text,
  `entr_dire_logo` varchar(45) DEFAULT NULL,
  `entr_foto` varchar(45) DEFAULT NULL,
  `entr_url` varchar(150) DEFAULT NULL,
  `entr_fechareg` datetime DEFAULT NULL,
  `entr_fechapub` datetime DEFAULT NULL,
  `entr_espublico` bit(1) NOT NULL DEFAULT b'1',
  `entr_fechaven` datetime DEFAULT NULL,
  `entr_pmas` int(11) NOT NULL DEFAULT '0',
  `entr_pmenos` int(11) NOT NULL DEFAULT '0',
  `entr_cate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`entr_id`) USING BTREE,
  KEY `fk_empleo_usuario1_idx` (`entr_usua_id`) USING BTREE,
  KEY `fk_entrada_entrada_categoria1_idx` (`entr_cate_id`) USING BTREE,
  KEY `fk_entrada_entrada_tipo1_idx` (`entr_tipo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`entr_id`, `entr_tipo_id`, `entr_usua_id`, `entr_titulo`, `entr_resumen`, `entr_contenido`, `entr_dire_logo`, `entr_foto`, `entr_url`, `entr_fechareg`, `entr_fechapub`, `entr_espublico`, `entr_fechaven`, `entr_pmas`, `entr_pmenos`, `entr_cate_id`) VALUES
(22, NULL, NULL, '5464', NULL, '456546 4 54 645 6', NULL, NULL, '', '2022-02-21 08:38:31', NULL, b'1', NULL, 0, 0, 1),
(23, NULL, NULL, '5464', NULL, '456546 4 54 645 6', NULL, NULL, '', '2022-02-21 08:40:37', NULL, b'1', NULL, 0, 0, 1),
(24, NULL, NULL, 'titulo 1', NULL, 'contenido', NULL, NULL, 'referencia', '2022-02-21 08:42:12', NULL, b'1', NULL, 0, 0, 1),
(25, NULL, NULL, 'dsfsdf', NULL, 'sdfsdfsd fsdf sdf&nbsp;', NULL, NULL, 'fsd sd fsdf ', '2022-02-21 08:48:15', NULL, b'1', NULL, 0, 0, 1),
(26, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 16:53:44', NULL, b'1', NULL, 0, 0, 1),
(27, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 16:57:29', NULL, b'1', NULL, 0, 0, 1),
(28, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 16:58:01', NULL, b'1', NULL, 0, 0, 1),
(29, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 16:58:20', NULL, b'1', NULL, 0, 0, 1),
(30, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 16:58:29', NULL, b'1', NULL, 0, 0, 1),
(31, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 16:58:57', NULL, b'1', NULL, 0, 0, 1),
(32, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 17:04:43', NULL, b'1', NULL, 0, 0, 1),
(33, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 17:15:44', NULL, b'1', NULL, 0, 0, 1),
(34, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 17:23:08', NULL, b'1', NULL, 0, 0, 1),
(35, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 17:23:25', NULL, b'1', NULL, 0, 0, 1),
(36, NULL, NULL, 'fgh', NULL, '<br />\r\n', NULL, NULL, '', '2022-02-21 17:24:24', NULL, b'1', NULL, 0, 0, 1),
(37, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:29:21', NULL, b'1', NULL, 0, 0, 1),
(38, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:29:36', NULL, b'1', NULL, 0, 0, 1),
(39, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:32:21', NULL, b'1', NULL, 0, 0, 1),
(40, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:33:05', NULL, b'1', NULL, 0, 0, 1),
(41, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:33:39', NULL, b'1', NULL, 0, 0, 1),
(42, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:33:55', NULL, b'1', NULL, 0, 0, 1),
(43, NULL, NULL, 'sdfsdf', NULL, 'sdfsdf', NULL, NULL, '', '2022-02-21 17:34:22', NULL, b'1', NULL, 0, 0, 1),
(44, NULL, NULL, 'sdf', NULL, 'df', NULL, NULL, '', '2022-02-21 17:36:38', NULL, b'1', NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_categoria`
--

DROP TABLE IF EXISTS `entrada_categoria`;
CREATE TABLE IF NOT EXISTS `entrada_categoria` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_tipo_id` int(11) DEFAULT NULL,
  `cate_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE,
  KEY `fk_entrada_categoria_entrada_tipo1_idx` (`cate_tipo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `entrada_categoria`
--

INSERT INTO `entrada_categoria` (`cate_id`, `cate_tipo_id`, `cate_nombre`) VALUES
(1, 1, 'Política'),
(2, 2, 'Comunicados'),
(3, 3, 'Agencias de viaje'),
(4, 4, 'Reportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_tipo`
--

DROP TABLE IF EXISTS `entrada_tipo`;
CREATE TABLE IF NOT EXISTS `entrada_tipo` (
  `tipo_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tipo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entrada_tipo`
--

INSERT INTO `entrada_tipo` (`tipo_id`, `tipo_nombre`) VALUES
(1, 'Noticias'),
(2, 'Anuncios'),
(3, 'Directorio'),
(4, 'Mapa');

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
  KEY `fk_incidencia_usuario1_idx` (`inci_usua_id`),
  KEY `fk_incidencia_incidencia_tegoria1_idx` (`inci_cate_id`)
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
  PRIMARY KEY (`usua_id`) USING BTREE,
  UNIQUE KEY `unico_mail_egresado` (`usua_email`) USING BTREE,
  KEY `fk_usuario_usuario_tipo1_idx` (`usua_tipo_id`) USING BTREE
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
  `rela_valora` bit(1) DEFAULT NULL,
  `rela_deta_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`rela_id`),
  KEY `fk_usuario_encuesta_encuesta1_idx` (`rela_encu_id`),
  KEY `fk_usuario_encuesta_usuario1_idx` (`rela_usua_id`)
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
  KEY `fk_usuario_entrada_entrada1_idx` (`rela_entr_id`) USING BTREE,
  KEY `fk_usuario_entrada_usuario1_idx` (`rela_usua_id`) USING BTREE
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
-- Filtros para la tabla `encuesta_detalle`
--
ALTER TABLE `encuesta_detalle`
  ADD CONSTRAINT `fk_encuesta_detalle_encuesta1` FOREIGN KEY (`deta_encu_id`) REFERENCES `encuesta` (`encu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entrada_categoria`
--
ALTER TABLE `entrada_categoria`
  ADD CONSTRAINT `fk_entrada_categoria_entrada_tipo1` FOREIGN KEY (`cate_tipo_id`) REFERENCES `entrada_tipo` (`tipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
