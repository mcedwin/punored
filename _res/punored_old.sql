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

 Date: 14/02/2022 07:59:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for entidad
-- ----------------------------
DROP TABLE IF EXISTS `entidad`;
CREATE TABLE `entidad`  (
  `enti_id` int(11) NOT NULL AUTO_INCREMENT,
  `enti_nombre` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `enti_regi_id` int(11) NULL DEFAULT NULL,
  `enti_direccion` varchar(155) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `enti_url` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `enti_bot_revision` int(11) NULL DEFAULT NULL,
  `enti_bot_encontrado` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `enti_bot_old` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `enti_bot_new` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `enti_bot_fechareg` datetime(0) NULL DEFAULT NULL,
  `enti_logo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `enti_cate_id` int(11) NULL DEFAULT NULL,
  `enti_bot_url` varchar(155) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`enti_id`) USING BTREE,
  INDEX `fk_entidad_entidad_categoria1_idx`(`enti_cate_id`) USING BTREE,
  CONSTRAINT `fk_entidad_entidad_categoria1` FOREIGN KEY (`enti_cate_id`) REFERENCES `entidad_categoria` (`cate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for entidad_categoria
-- ----------------------------
DROP TABLE IF EXISTS `entidad_categoria`;
CREATE TABLE `entidad_categoria`  (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_nombre` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
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
  `entr_ubig_id` int(11) NULL DEFAULT NULL,
  `entr_foto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entr_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entr_area_id` int(11) NULL DEFAULT NULL,
  `entr_empl_remu_id` int(11) NULL DEFAULT NULL,
  `entr_empl_cont_id` int(11) NULL DEFAULT NULL,
  `entr_empl_hora_id` int(11) NULL DEFAULT NULL,
  `entr_fechareg` datetime(0) NULL DEFAULT NULL,
  `entr_fechapub` datetime(0) NULL DEFAULT NULL,
  `entr_fechadie` datetime(0) NULL DEFAULT NULL,
  `entr_espublico` bit(1) NOT NULL DEFAULT b'1',
  `entr_pmas` int(11) NOT NULL DEFAULT 0,
  `entr_pmenos` int(11) NOT NULL DEFAULT 0,
  `entr_even_fechaini` datetime(0) NULL DEFAULT NULL,
  `entr_even_fechafin` datetime(0) NULL DEFAULT NULL,
  `entr_cate_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`entr_id`) USING BTREE,
  INDEX `fk_trabajo_trabajo_remuneracion1_idx`(`entr_empl_remu_id`) USING BTREE,
  INDEX `fk_trabajo_trabajo_contrato1_idx`(`entr_empl_cont_id`) USING BTREE,
  INDEX `fk_empleo_empl_horario1_idx`(`entr_empl_hora_id`) USING BTREE,
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
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `usua_id` int(11) NOT NULL AUTO_INCREMENT,
  `usua_nombres` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_apellidos` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_dniruc` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_movil` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_email` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_password` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_ubig_id` int(11) NULL DEFAULT NULL,
  `usua_foto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `usua_lastip` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_rsocial` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_tipo_id` int(11) NULL DEFAULT NULL,
  `usua_password2` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usua_activo` bit(1) NOT NULL DEFAULT b'1',
  `usua_nick` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`usua_id`) USING BTREE,
  UNIQUE INDEX `unico_mail_egresado`(`usua_email`) USING BTREE,
  INDEX `fk_usuario_usuario_tipo1_idx`(`usua_tipo_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (6, 'gfh', NULL, NULL, NULL, 'fgh@sdfsdf.com', '0f98df87c7440c045496f705c7295344', NULL, NULL, NULL, NULL, NULL, 1, '4d788c035477d1736a1c19c887670925', b'1', NULL);
INSERT INTO `usuario` VALUES (7, 'ert', NULL, NULL, NULL, 'ertert', 'e3e84538a1b02b1cc11bf71fe3169958', NULL, NULL, NULL, NULL, NULL, 1, '63d79f99724dfe7bd44e05138f29c2be', b'1', NULL);
INSERT INTO `usuario` VALUES (8, 'ert', NULL, NULL, NULL, 'ertertdsf', 'e3e84538a1b02b1cc11bf71fe3169958', NULL, NULL, NULL, NULL, NULL, 1, '52a0bf0a57bb2a360c59f2b75d7e77db', b'1', NULL);
INSERT INTO `usuario` VALUES (9, 'sdfsdf', NULL, NULL, NULL, 'sdfsdf', 'd9729feb74992cc3482b350163a1a010', NULL, NULL, NULL, NULL, NULL, 1, 'aa3c7e186b972517fc625b38e3e58e80', b'1', NULL);
INSERT INTO `usuario` VALUES (10, 'dsfsdf', NULL, NULL, NULL, 'sdfsdfss', 'd9729feb74992cc3482b350163a1a010', NULL, NULL, NULL, NULL, NULL, 1, '357b9e04168658f1e06f4ed83419a784', b'1', NULL);

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
