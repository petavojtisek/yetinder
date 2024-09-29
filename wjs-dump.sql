/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50731
Source Host           : localhost:3306
Source Database       : wjs

Target Server Type    : MYSQL
Target Server Version : 50731
File Encoding         : 65001

Date: 2024-09-29 14:15:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wjs_comment
-- ----------------------------
DROP TABLE IF EXISTS `wjs_comment`;
CREATE TABLE `wjs_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `published_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_366BF14D4B89032C` (`post_id`),
  KEY `IDX_366BF14DF675F31B` (`author_id`),
  KEY `published_at` (`published_at`),
  CONSTRAINT `FK_366BF14D4B89032C` FOREIGN KEY (`post_id`) REFERENCES `wjs_post` (`id`),
  CONSTRAINT `FK_366BF14DF675F31B` FOREIGN KEY (`author_id`) REFERENCES `wjs_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wjs_comment
-- ----------------------------
INSERT INTO `wjs_comment` VALUES ('61', '106', '141', '3', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('62', '106', '141', '5', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('63', '106', '141', '2', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('64', '106', '141', '5', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('65', '106', '141', '4', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('66', '107', '141', '5', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('67', '107', '141', '3', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('68', '107', '141', '5', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('69', '107', '141', '2', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('70', '107', '141', '3', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('71', '108', '141', '1', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('72', '108', '141', '2', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('73', '108', '141', '3', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('74', '108', '141', '2', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('75', '108', '141', '3', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('76', '109', '141', '2', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('77', '109', '141', '1', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('78', '109', '141', '1', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('79', '109', '141', '5', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('80', '109', '141', '5', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('81', '110', '141', '2', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('82', '110', '141', '4', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('83', '110', '141', '3', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('84', '110', '141', '3', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('85', '110', '141', '3', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('86', '111', '141', '5', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('87', '111', '141', '2', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('88', '111', '141', '1', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('89', '111', '141', '3', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('90', '111', '141', '4', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('91', '112', '141', '4', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('92', '112', '141', '3', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('93', '112', '141', '2', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('94', '112', '141', '1', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('95', '112', '141', '2', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('96', '113', '141', '1', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('97', '113', '141', '4', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('98', '113', '141', '4', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('99', '113', '141', '5', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('100', '113', '141', '2', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('101', '114', '141', '5', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('102', '114', '141', '3', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('103', '114', '141', '3', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('104', '114', '141', '2', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('105', '114', '141', '2', '2024-09-29 12:12:58');
INSERT INTO `wjs_comment` VALUES ('106', '115', '141', '4', '2024-09-29 12:12:54');
INSERT INTO `wjs_comment` VALUES ('107', '115', '141', '5', '2024-09-29 12:12:55');
INSERT INTO `wjs_comment` VALUES ('108', '115', '141', '3', '2024-09-29 12:12:56');
INSERT INTO `wjs_comment` VALUES ('109', '115', '141', '2', '2024-09-29 12:12:57');
INSERT INTO `wjs_comment` VALUES ('110', '115', '141', '4', '2024-09-29 12:12:58');

-- ----------------------------
-- Table structure for wjs_post
-- ----------------------------
DROP TABLE IF EXISTS `wjs_post`;
CREATE TABLE `wjs_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` double NOT NULL,
  `weight` int(11) NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `points` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A04AC0AFF675F31B` (`author_id`),
  KEY `city` (`city`),
  KEY `gender` (`gender`),
  KEY `width` (`width`),
  KEY `weight` (`weight`),
  KEY `zip` (`zip`),
  KEY `country` (`country`),
  KEY `slug` (`slug`),
  KEY `points` (`points`),
  KEY `published_at` (`published_at`),
  CONSTRAINT `FK_A04AC0AFF675F31B` FOREIGN KEY (`author_id`) REFERENCES `wjs_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wjs_post
-- ----------------------------
INSERT INTO `wjs_post` VALUES ('106', '150', 'Ledový Vládce', 'Yarik', 'M', '341', '795', 'Děčínská 310', 'Nedašov', '66403', 'PL', 'yarik', 'Chladný a mazaný, vždy ve střehu.', '2024-09-29 14:42:30', '19', 'M5.jpg');
INSERT INTO `wjs_post` VALUES ('107', '145', 'Ledový Vládce', 'Kaltok', 'M', '391', '525', 'Jevišovická 228/14', 'Doksy', '50703', 'PL', 'kaltok', 'Silný ochránce hor s mocným duchem', '2024-09-28 14:14:28', '18', 'M1.jpg');
INSERT INTO `wjs_post` VALUES ('108', '151', 'Lovec Yeti', 'Thagor', 'M', '237', '263', 'Střední 9', 'Praha', '28103', 'CZ', 'thagor', 'Chladný a mazaný, vždy ve střehu.', '2024-09-27 13:13:20', '11', 'M4.jpg');
INSERT INTO `wjs_post` VALUES ('109', '143', 'Sněžný Hrdina', 'Borvok', 'M', '378', '532', 'Jiráskova 283', 'Třebíč', '28103', 'CZ', 'borvok', 'Chladný a mazaný, vždy ve střehu.', '2024-09-26 17:43:16', '14', 'M1.jpg');
INSERT INTO `wjs_post` VALUES ('110', '148', 'Lovec Yeti', 'Gorvoth', 'M', '336', '357', 'Krňany 73', 'Brno', '51231', 'CZ', 'gorvoth', 'Nebojácný hrdina, co brání své území.', '2024-09-25 09:11:05', '15', 'M3.jpg');
INSERT INTO `wjs_post` VALUES ('111', '150', 'Sněžná Princezna', 'Luminia', 'F', '297', '248', 'Ponětovická 8', 'Jesenice okr. Rakovník', '12000', 'CZ', 'luminia', 'Fascinující rusalka, co okouzlí každého.', '2024-09-24 16:27:31', '15', 'F3.jpg');
INSERT INTO `wjs_post` VALUES ('112', '142', 'Horská Rusalka', 'Avalyn', 'F', '366', '678', 'Blachutova 930/2', 'Brno', '67571', 'CZ', 'avalyn', 'Záhadná sněhule, co se zjevuje v noci.', '2024-09-23 10:23:17', '12', 'F5.jpg');
INSERT INTO `wjs_post` VALUES ('113', '149', 'Ledová Drakona', 'Nevira', 'F', '325', '246', 'Tichá 413', 'Brno', '47107', 'CZ', 'nevira', 'Královna sněhu s elegancí a grácií.', '2024-09-22 14:34:00', '16', 'F5.jpg');
INSERT INTO `wjs_post` VALUES ('114', '143', 'Ledová Drakona', 'Kalindi', 'F', '397', '539', 'Družstevní 76', 'Praha', '74724', 'CZ', 'kalindi', 'Silná bojovnice, co chrání svá tajemství.', '2024-09-21 15:07:25', '15', 'F4.jpg');
INSERT INTO `wjs_post` VALUES ('115', '146', 'Horská Rusalka', 'Vedrana', 'F', '382', '559', 'Kotrčova 615', 'Nedašov', '47107', 'CZ', 'vedrana', 'Moudrá mágyně, co rozumí přírodě.', '2024-09-20 09:36:09', '18', 'F5.jpg');

-- ----------------------------
-- Table structure for wjs_user
-- ----------------------------
DROP TABLE IF EXISTS `wjs_user`;
CREATE TABLE `wjs_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_77537A6BF85E0677` (`username`),
  UNIQUE KEY `UNIQ_77537A6BE7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wjs_user
-- ----------------------------
INSERT INTO `wjs_user` VALUES ('141', 'John Doe', 'john_user', 'john_user@symfony.com', '$2y$13$AJIW1otpia6WyRB0P5XAi.hx3WaJnsH3knVqRNLAfGdSqoAtY332O', '[\"ROLE_USER\"]', 'M');
INSERT INTO `wjs_user` VALUES ('142', 'Petr V', 'petr', 'petr@symfony.com', '$2y$13$gCvNu3zmo3ztljlJhrXTN.PKxE/SyYUfgRl9FSSBSNeETuNh.7WH6', '[\"ROLE_USER\"]', 'M');
INSERT INTO `wjs_user` VALUES ('143', 'Katina Mccall', 'katina', 'Katina@symfony.com', '$2y$13$3DeEFTbDuHVLFdabYbVBC.RmryiSk3liovVL4CSnGasRaZhv/e9Ci', '[\"ROLE_USER\"]', 'F');
INSERT INTO `wjs_user` VALUES ('144', 'Phillip Beltran', 'phillip', 'Phillip@symfony.com', '$2y$13$2Gi5G.gGHaBrhpkzVmFVmeu3Q0eYmn4LdCo8sfX5vYNTfizGZE3yW', '[\"ROLE_USER\"]', 'M');
INSERT INTO `wjs_user` VALUES ('145', 'Millie Stephenson', 'millie', 'Millie@symfony.com', '$2y$13$TKvTOHbNg2WAcHJnIO.4NuEQihOXsWPh7YGAfJZPN9P0sJZD0JKR6', '[\"ROLE_USER\"]', 'F');
INSERT INTO `wjs_user` VALUES ('146', 'Lenny Kerr', 'lenny', 'Lenny@symfony.com', '$2y$13$M6PLA9DFLo.rAXOeziXgj.GioUXTuxah4cdBHi6af5JFTzNEB18Ga', '[\"ROLE_USER\"]', 'M');
INSERT INTO `wjs_user` VALUES ('147', 'Edison Lyons', 'edison', 'Edison@symfony.com', '$2y$13$LhfbYaGYCjFlrRLjhVbwT.3F1hQrlU/Ml6YvSgAOSwrALZwzg9sw2', '[\"ROLE_USER\"]', 'F');
INSERT INTO `wjs_user` VALUES ('148', 'Cathryn Benitez', 'cathryn', 'Cathryn@symfony.com', '$2y$13$eEykP0NkdLCzgfazV23jL.hh3wuwYYN25lp1dU3tcnCdMQmGk/BHq', '[\"ROLE_USER\"]', 'F');
INSERT INTO `wjs_user` VALUES ('149', 'Ladonna Morrison', 'ladonna', 'Ladonna@symfony.com', '$2y$13$55VwgunI6t3BE0aKPwlIfOueQdc79BgEUmckIiFtY5.C4Jsa5q7j6', '[\"ROLE_USER\"]', 'F');
INSERT INTO `wjs_user` VALUES ('150', 'Julianne Merritt', 'julianne', 'Julianne@symfony.com', '$2y$13$0CcYj5vbr/jULc/EQZBnrO2aGumi.UV4u4Ha3OkfsYQ.88YdfzOuq', '[\"ROLE_USER\"]', 'J');
INSERT INTO `wjs_user` VALUES ('151', 'Oswaldo Lowe', 'oswaldo', 'Oswaldo@symfony.com', '$2y$13$pxcCMR85RscmiTjptEalauAPJz72e5HLe9Ba.mBJp4Kgz1F3W5Aga', '[\"ROLE_USER\"]', 'M');
INSERT INTO `wjs_user` VALUES ('152', 'Josef Randall', 'josef', 'Josef@symfony.com', '$2y$13$mJE7X6s1ZuJjpweHGv8ySubKAZgJwvGWUMSzqE2D90zuOetq0aw/u', '[\"ROLE_USER\"]', 'M');
SET FOREIGN_KEY_CHECKS=1;
