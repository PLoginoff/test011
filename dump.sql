drop database if exists `crossover`;
create database `crossover`;
drop user if exists 'crossover'@'localhost';
create user 'crossover'@'localhost' identified by 'crossover';
grant all privileges on `crossover`.* to 'crossover'@'localhost';

use `crossover`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` VALUES (1,'Pavel.Loginov@example.com','$2y$13$CROSSOVERROCKCROSSOVEOajJp9dg9l.cls6P34p1AZ/fvLlMI9Ou',1,NULL);

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66A76ED395` (`user_id`),
  KEY `published_idx` (`published`),
  CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `article` VALUES (1,1,'MCC is here','Moscow Central Circle has arrived. One can criticize, argue about corruption, say that this is Russia, bro... Or you can make it come true in spite of anything. I am amazed.','996ab73d9f53ec758489dbd0a7449767.jpg',1,'2016-09-26 15:37:34'),(2,1,'Syria conflict: US and UK speeches \'unacceptable\' - Russia','Russia has criticised the US and UK for using \"unacceptable\" tone and rhetoric in speeches on Syria at the UN, after being accused of \"barbarism\".','2b62ead3582b861d887c0b6d93c8ea5a.jpg',1,'2016-09-26 15:38:39');
