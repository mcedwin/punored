/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : punored

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 17/02/2022 16:11:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for anuncio
-- ----------------------------
DROP TABLE IF EXISTS `anuncio`;
CREATE TABLE `anuncio`  (
  `anun_id` int(11) NOT NULL AUTO_INCREMENT,
  `anun_usua_id` int(11) NULL DEFAULT NULL,
  `anun_cate_id` int(11) NULL DEFAULT NULL,
  `anun_titulo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `anun_descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `anun_foto` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `anun_url` varchar(145) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `anun_fechareg` datetime(0) NULL DEFAULT NULL,
  `anun_fechapub` datetime(0) NULL DEFAULT NULL,
  `anun_fechaven` datetime(0) NULL DEFAULT NULL,
  `anun_espublico` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`anun_id`) USING BTREE,
  INDEX `fk_anuncio_usuario1_idx`(`anun_usua_id`) USING BTREE,
  INDEX `fk_anuncio_anuncio_categoria1_idx`(`anun_cate_id`) USING BTREE,
  CONSTRAINT `fk_anuncio_anuncio_categoria1` FOREIGN KEY (`anun_cate_id`) REFERENCES `anuncio_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_anuncio_usuario1` FOREIGN KEY (`anun_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for anuncio_categoria
-- ----------------------------
DROP TABLE IF EXISTS `anuncio_categoria`;
CREATE TABLE `anuncio_categoria`  (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for directorio
-- ----------------------------
DROP TABLE IF EXISTS `directorio`;
CREATE TABLE `directorio`  (
  `dire_id` int(11) NOT NULL AUTO_INCREMENT,
  `dire_nombre` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dire_resumen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dire_contenido` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `dire_pmas` int(11) NULL DEFAULT NULL,
  `dire_pmenos` int(11) NULL DEFAULT NULL,
  `dire_logo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dire_imagen` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dire_cate_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`dire_id`) USING BTREE,
  INDEX `fk_directorio_directorio_categoria1_idx`(`dire_cate_id`) USING BTREE,
  CONSTRAINT `fk_directorio_directorio_categoria1` FOREIGN KEY (`dire_cate_id`) REFERENCES `directorio_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for directorio_categoria
-- ----------------------------
DROP TABLE IF EXISTS `directorio_categoria`;
CREATE TABLE `directorio_categoria`  (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for encuesta
-- ----------------------------
DROP TABLE IF EXISTS `encuesta`;
CREATE TABLE `encuesta`  (
  `encu_id` int(11) NOT NULL AUTO_INCREMENT,
  `encu_titulo` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `encu_descripcion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `encu_foto` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `encu_usua_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`encu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for encuesta_detalle
-- ----------------------------
DROP TABLE IF EXISTS `encuesta_detalle`;
CREATE TABLE `encuesta_detalle`  (
  `deta_id` int(11) NOT NULL AUTO_INCREMENT,
  `deta_encu_id` int(11) NULL DEFAULT NULL,
  `deta_alternativa` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `deta_puntos` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`deta_id`) USING BTREE,
  INDEX `fk_encuesta_detalle_encuesta1_idx`(`deta_encu_id`) USING BTREE,
  CONSTRAINT `fk_encuesta_detalle_encuesta1` FOREIGN KEY (`deta_encu_id`) REFERENCES `encuesta` (`encu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for entrada
-- ----------------------------
DROP TABLE IF EXISTS `entrada`;
CREATE TABLE `entrada`  (
  `entr_id` int(11) NOT NULL AUTO_INCREMENT,
  `entr_usua_id` int(11) NULL DEFAULT NULL,
  `entr_titulo` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entr_descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `entr_foto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entr_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entr_area_id` int(11) NULL DEFAULT NULL,
  `entr_fechareg` datetime(0) NULL DEFAULT NULL,
  `entr_fechapub` datetime(0) NULL DEFAULT NULL,
  `entr_espublico` bit(1) NOT NULL DEFAULT b'1',
  `entr_pmas` int(11) NOT NULL DEFAULT 0,
  `entr_pmenos` int(11) NOT NULL DEFAULT 0,
  `entr_cate_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`entr_id`) USING BTREE,
  INDEX `fk_empleo_usuario1_idx`(`entr_usua_id`) USING BTREE,
  INDEX `fk_entrada_habilidad_area1_idx`(`entr_area_id`) USING BTREE,
  INDEX `fk_entrada_entrada_categoria1_idx`(`entr_cate_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for entrada_categoria
-- ----------------------------
DROP TABLE IF EXISTS `entrada_categoria`;
CREATE TABLE `entrada_categoria`  (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of entrada_categoria
-- ----------------------------
INSERT INTO `entrada_categoria` VALUES (1, 'dfsdf');

-- ----------------------------
-- Table structure for incidencia
-- ----------------------------
DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE `incidencia`  (
  `inci_id` int(11) NOT NULL AUTO_INCREMENT,
  `inci_titulo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `inci_descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `inci_foto` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `inci_latitude` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `inci_longitude` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `inci_pmas` int(11) NULL DEFAULT NULL,
  `inci_pmenos` int(11) NULL DEFAULT NULL,
  `inci_espublico` bit(1) NULL DEFAULT NULL,
  `inci_cate_id` int(11) NULL DEFAULT NULL,
  `inci_usua_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`inci_id`) USING BTREE,
  INDEX `fk_incidencia_usuario1_idx`(`inci_usua_id`) USING BTREE,
  INDEX `fk_incidencia_incidencia_tegoria1_idx`(`inci_cate_id`) USING BTREE,
  CONSTRAINT `fk_incidencia_incidencia_tegoria1` FOREIGN KEY (`inci_cate_id`) REFERENCES `incidencia_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_incidencia_usuario1` FOREIGN KEY (`inci_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for incidencia_categoria
-- ----------------------------
DROP TABLE IF EXISTS `incidencia_categoria`;
CREATE TABLE `incidencia_categoria`  (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `usua_id` int(11) NOT NULL AUTO_INCREMENT,
  `usua_nombres` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_movil` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_email` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_password` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_foto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `usua_password2` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_activo` bit(1) NOT NULL DEFAULT b'1',
  `usua_tipo_id` int(11) NULL DEFAULT NULL,
  `usua_lastip` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`usua_id`) USING BTREE,
  UNIQUE INDEX `unico_mail_egresado`(`usua_email`) USING BTREE,
  INDEX `fk_usuario_usuario_tipo1_idx`(`usua_tipo_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (6, 'gfh', NULL, 'fgh@sdfsdf.com', '0f98df87c7440c045496f705c7295344', NULL, NULL, '4d788c035477d1736a1c19c887670925', b'1', 1, NULL);
INSERT INTO `usuario` VALUES (7, 'ert', NULL, 'ertert', 'e3e84538a1b02b1cc11bf71fe3169958', NULL, NULL, '63d79f99724dfe7bd44e05138f29c2be', b'1', 1, NULL);
INSERT INTO `usuario` VALUES (8, 'ert', NULL, 'ertertdsf', 'e3e84538a1b02b1cc11bf71fe3169958', NULL, NULL, '52a0bf0a57bb2a360c59f2b75d7e77db', b'1', 1, NULL);
INSERT INTO `usuario` VALUES (9, 'sdfsdf', NULL, 'sdfsdf', 'd9729feb74992cc3482b350163a1a010', NULL, NULL, 'aa3c7e186b972517fc625b38e3e58e80', b'1', 1, NULL);
INSERT INTO `usuario` VALUES (10, 'dsfsdf', NULL, 'sdfsdfss', 'd9729feb74992cc3482b350163a1a010', NULL, NULL, '357b9e04168658f1e06f4ed83419a784', b'1', 1, NULL);
INSERT INTO `usuario` VALUES (11, 'Edwin', NULL, 'mcedwin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '5c0b92d1eff1f9a066f204e31c36ae96', b'1', 1, NULL);

-- ----------------------------
-- Table structure for usuario_encuesta
-- ----------------------------
DROP TABLE IF EXISTS `usuario_encuesta`;
CREATE TABLE `usuario_encuesta`  (
  `rela_id` int(11) NOT NULL,
  `rela_usua_id` int(11) NULL DEFAULT NULL,
  `rela_encu_id` int(11) NULL DEFAULT NULL,
  `rela_fechareg` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`rela_id`) USING BTREE,
  INDEX `fk_usuario_encuesta_encuesta1_idx`(`rela_encu_id`) USING BTREE,
  INDEX `fk_usuario_encuesta_usuario1_idx`(`rela_usua_id`) USING BTREE,
  CONSTRAINT `fk_usuario_encuesta_encuesta1` FOREIGN KEY (`rela_encu_id`) REFERENCES `encuesta` (`encu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_encuesta_usuario1` FOREIGN KEY (`rela_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usuario_entrada
-- ----------------------------
DROP TABLE IF EXISTS `usuario_entrada`;
CREATE TABLE `usuario_entrada`  (
  `rela_id` int(11) NOT NULL AUTO_INCREMENT,
  `rela_usua_id` int(11) NULL DEFAULT NULL,
  `rela_entr_id` int(11) NULL DEFAULT NULL,
  `rela_nmas` int(11) NOT NULL DEFAULT 0,
  `rela_nmenos` int(11) NOT NULL DEFAULT 0,
  `rela_like` bit(1) NOT NULL DEFAULT b'0',
  `rela_fechareg` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`rela_id`) USING BTREE,
  INDEX `fk_usuario_entrada_entrada1_idx`(`rela_entr_id`) USING BTREE,
  INDEX `fk_usuario_entrada_usuario1_idx`(`rela_usua_id`) USING BTREE,
  CONSTRAINT `fk_usuario_entrada_entrada1` FOREIGN KEY (`rela_entr_id`) REFERENCES `entrada` (`entr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_entrada_usuario1` FOREIGN KEY (`rela_usua_id`) REFERENCES `usuario` (`usua_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usuario_tipo
-- ----------------------------
DROP TABLE IF EXISTS `usuario_tipo`;
CREATE TABLE `usuario_tipo`  (
  `tipo_id` int(11) NOT NULL,
  `tipo_nombre` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`tipo_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
