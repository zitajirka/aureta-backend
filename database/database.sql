SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `gritbox_devel`;
CREATE DATABASE `gritbox_devel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci */;
USE `gritbox_devel`;

DELIMITER ;;

CREATE EVENT `password_reset_ttl` ON SCHEDULE EVERY 1 HOUR STARTS '2015-02-07 03:03:13' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `user` SET `password_reset_hash` = '' WHERE `password_reset_creation_time` < NOW() - INTERVAL 24 HOUR;;

DELIMITER ;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `registration_time` datetime NOT NULL,
  `role` enum('user','admin') COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_creation_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;