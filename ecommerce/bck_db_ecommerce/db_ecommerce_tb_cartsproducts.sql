-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: db_ecommerce
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_cartsproducts`
--

DROP TABLE IF EXISTS `tb_cartsproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_cartsproducts` (
  `idcartproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcartproduct`),
  KEY `FK_cartsproducts_carts_idx` (`idcart`),
  KEY `fk_cartsproducts_products_idx` (`idproduct`),
  CONSTRAINT `fk_cartsproducts_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartsproducts_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cartsproducts`
--

LOCK TABLES `tb_cartsproducts` WRITE;
/*!40000 ALTER TABLE `tb_cartsproducts` DISABLE KEYS */;
INSERT INTO `tb_cartsproducts` VALUES (1,1,4,'0000-00-00 00:00:00','2017-11-21 13:30:44'),(2,1,4,'0000-00-00 00:00:00','2017-11-21 13:30:56'),(3,1,4,'0000-00-00 00:00:00','2017-11-21 13:31:58'),(4,1,4,'2017-11-21 11:55:16','2017-11-21 13:44:12'),(5,1,4,'2017-11-21 11:56:05','2017-11-21 13:55:03'),(6,1,4,'2017-11-21 11:56:08','2017-11-21 13:55:42'),(7,1,4,'2017-11-21 11:56:12','2017-11-21 13:55:52'),(8,1,4,'2017-11-21 11:57:21','2017-11-21 13:56:00'),(9,1,4,'2017-11-21 11:57:23','2017-11-21 13:56:45'),(10,1,4,'2017-11-21 11:57:25','2017-11-21 13:57:18'),(11,1,4,'2017-11-21 11:58:22','2017-11-21 13:57:34'),(12,1,4,'2017-11-21 11:58:22','2017-11-21 13:57:37'),(13,1,3,'2017-11-21 12:06:27','2017-11-21 14:05:50'),(14,1,3,'2017-11-21 12:06:30','2017-11-21 14:05:50'),(15,1,3,'2017-11-22 08:55:30','2017-11-21 14:05:50'),(16,1,3,'2017-11-22 08:55:30','2017-11-21 14:05:51'),(17,1,3,'2017-11-22 08:55:30','2017-11-21 14:06:24'),(18,1,3,'2017-11-22 08:55:30','2017-11-21 14:06:24'),(19,1,6,'2017-11-22 08:55:28','2017-11-21 14:06:53'),(20,1,6,'2017-11-22 08:55:28','2017-11-21 14:06:53'),(21,1,4,'2017-11-21 12:10:21','2017-11-21 14:07:08'),(22,1,4,'2017-11-22 08:55:25','2017-11-21 14:07:08'),(23,1,1,'2017-11-22 08:55:32','2017-11-21 14:07:18'),(24,1,1,'2017-11-22 08:55:32','2017-11-21 14:07:18'),(25,1,1,'2017-11-22 09:02:53','2017-11-22 10:55:43'),(26,1,1,'2017-11-22 09:02:53','2017-11-22 10:55:44'),(27,1,7,'2017-11-22 09:14:33','2017-11-22 11:03:10'),(28,1,7,'2017-11-22 09:14:33','2017-11-22 11:03:10'),(29,1,7,'2017-11-22 09:14:33','2017-11-22 11:03:10'),(30,1,7,'2017-11-22 09:14:33','2017-11-22 11:03:10'),(31,1,4,'2017-11-23 09:40:27','2017-11-22 11:14:39'),(32,1,3,'2017-11-22 12:01:16','2017-11-22 11:14:51'),(33,1,3,'2017-11-22 12:01:16','2017-11-22 11:14:51'),(34,1,4,'2017-11-23 09:41:54','2017-11-23 11:40:15'),(35,1,4,'2017-11-23 09:42:11','2017-11-23 11:40:19'),(36,1,4,'2017-11-23 09:50:23','2017-11-23 11:41:57'),(37,1,4,'2017-11-23 09:50:53','2017-11-23 11:42:21'),(38,1,4,'2017-11-23 09:50:57','2017-11-23 11:50:30'),(39,1,4,'2017-11-23 09:51:00','2017-11-23 11:50:33'),(40,1,4,'2017-11-23 10:03:25','2017-11-23 11:50:39'),(41,1,4,'2017-11-23 10:03:28','2017-11-23 12:03:06'),(42,1,4,'2017-11-28 08:25:51','2017-11-23 12:03:10'),(43,1,4,NULL,'2017-11-27 13:42:17'),(44,1,3,'2017-12-08 10:57:28','2017-12-08 12:57:20'),(45,1,1,'2017-12-08 10:57:41','2017-12-08 12:57:34'),(46,1,5,NULL,'2017-12-08 12:57:49');
/*!40000 ALTER TABLE `tb_cartsproducts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-08 11:51:18
