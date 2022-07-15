/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.20-MariaDB-log : Database - zoom_photo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zoom_photo` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `zoom_photo`;

/*Table structure for table `zoom` */

DROP TABLE IF EXISTS `zoom`;

CREATE TABLE `zoom` (
  `intidzoom` int(11) NOT NULL AUTO_INCREMENT,
  `txtword` varchar(32) NOT NULL,
  `txtimage` varchar(64) NOT NULL,
  `inttextsize` tinyint(4) NOT NULL,
  `dtcreatedat` timestamp NULL DEFAULT current_timestamp(),
  `dtupdatedat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`intidzoom`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
