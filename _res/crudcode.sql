/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : crudcode

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 21/02/2022 09:17:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2022-01-09-170209', 'App\\Database\\Migrations\\TPersonas', 'default', 'App', 1641748114, 1);

-- ----------------------------
-- Table structure for t_personas
-- ----------------------------
DROP TABLE IF EXISTS `t_personas`;
CREATE TABLE `t_personas`  (
  `id_nombre` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `paterno` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `materno` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_nombre`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_personas
-- ----------------------------
INSERT INTO `t_personas` VALUES (2, 'maria', '', '');
INSERT INTO `t_personas` VALUES (3, 'jose', '', '');
INSERT INTO `t_personas` VALUES (7, '435', '345', '345');
INSERT INTO `t_personas` VALUES (6, '234fgh', '', '');
INSERT INTO `t_personas` VALUES (8, 'aa', 'aa', 'aa');
INSERT INTO `t_personas` VALUES (9, 'dfg', 'dfg', 'dfg');
INSERT INTO `t_personas` VALUES (10, '', '', '');
INSERT INTO `t_personas` VALUES (11, '', '', '');
INSERT INTO `t_personas` VALUES (12, '', '', '');
INSERT INTO `t_personas` VALUES (13, '', '', '');
INSERT INTO `t_personas` VALUES (14, '', '', '');
INSERT INTO `t_personas` VALUES (15, '', '', '');
INSERT INTO `t_personas` VALUES (16, '', '', '');
INSERT INTO `t_personas` VALUES (17, '', '', '');
INSERT INTO `t_personas` VALUES (18, '', '', '');
INSERT INTO `t_personas` VALUES (19, '', '', '');
INSERT INTO `t_personas` VALUES (20, '', '', '');
INSERT INTO `t_personas` VALUES (21, '', '', '');
INSERT INTO `t_personas` VALUES (22, '', '', '');
INSERT INTO `t_personas` VALUES (23, '', '', '');
INSERT INTO `t_personas` VALUES (24, '', '', '');
INSERT INTO `t_personas` VALUES (25, '', '', '');
INSERT INTO `t_personas` VALUES (26, 'tttttttttt', 'ttttttttttttttt', 'ttttttttttttttt');
INSERT INTO `t_personas` VALUES (27, 'tttttttttt', 'ttttttttttttttt', 'ttttttttttttttt');
INSERT INTO `t_personas` VALUES (28, 'tttttttttt', 'ttttttttttttttt', 'ttttttttttttttt');
INSERT INTO `t_personas` VALUES (29, '888', '888', '888');
INSERT INTO `t_personas` VALUES (30, '99', '99', '766');
INSERT INTO `t_personas` VALUES (31, '', '', '');
INSERT INTO `t_personas` VALUES (32, '', '', '');
INSERT INTO `t_personas` VALUES (33, '456', '456', '456');
INSERT INTO `t_personas` VALUES (34, '', '', '');
INSERT INTO `t_personas` VALUES (35, 'gvhfgh', 'fghfg', 'hfgh');

SET FOREIGN_KEY_CHECKS = 1;
