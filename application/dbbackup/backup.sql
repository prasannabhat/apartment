-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: apartment
-- ------------------------------------------------------
-- Server version	5.5.16

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
-- Table structure for table `house_user`
--

DROP TABLE IF EXISTS `house_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `house_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `house_id` int(10) unsigned NOT NULL,
  `relation` varchar(15) NOT NULL,
  `residing` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `house_user_user_id_foreign` (`user_id`),
  KEY `house_user_house_id_foreign` (`house_id`),
  CONSTRAINT `house_user_house_id_foreign` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `house_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `house_user`
--

LOCK TABLES `house_user` WRITE;
/*!40000 ALTER TABLE `house_user` DISABLE KEYS */;
INSERT INTO `house_user` VALUES (1,1,1,'tenant',1,'2012-10-11 11:30:05','2012-10-23 11:26:13'),(3,2,1,'owner',1,'2012-10-11 11:30:05','2012-10-23 10:49:11'),(4,3,4,'',0,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(5,4,5,'',0,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(10,3,1,'co-owner',0,'2012-10-23 08:45:47','2012-10-23 10:34:43'),(11,6,1,'co-owner',1,'2012-10-23 11:21:34','2012-10-23 11:21:34'),(13,7,2,'owner',1,'2012-10-23 11:40:11','2012-10-23 11:40:11');
/*!40000 ALTER TABLE `house_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `houses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `house_no` varchar(20) NOT NULL,
  `floor` varchar(20) NOT NULL,
  `block` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `houses_house_no_unique` (`house_no`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES (1,'D11','D','','2012-10-11 11:30:05','2012-10-11 11:30:05'),(2,'D8','D','','2012-10-11 11:30:05','2012-10-11 11:30:05'),(3,'C10','C','','2012-10-11 11:30:05','2012-10-11 11:30:05'),(4,'A10','A','','2012-10-11 11:30:05','2012-10-11 11:30:05'),(5,'D5','D','','2012-10-11 11:30:05','2012-10-11 11:30:05');
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laravel_migrations`
--

DROP TABLE IF EXISTS `laravel_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laravel_migrations`
--

LOCK TABLES `laravel_migrations` WRITE;
/*!40000 ALTER TABLE `laravel_migrations` DISABLE KEYS */;
INSERT INTO `laravel_migrations` VALUES ('application','2012_09_23_034420_create_tables',1),('application','2012_09_23_040522_create_data',1);
/*!40000 ALTER TABLE `laravel_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_no` varchar(15) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phones_user_id_foreign` (`user_id`),
  CONSTRAINT `phones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones`
--

LOCK TABLES `phones` WRITE;
/*!40000 ALTER TABLE `phones` DISABLE KEYS */;
INSERT INTO `phones` VALUES (1,'9880362090',0,2,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(2,'9972010366',0,2,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(3,'9888886323',0,3,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(4,'9888886523',0,4,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(5,'1234567890',0,5,'2012-10-15 08:37:37','2012-10-15 09:06:20'),(6,'1234567890',0,6,'2012-10-22 10:05:02','2012-10-22 10:05:02'),(7,'9880362090',0,7,'2012-10-23 11:30:23','2012-10-23 11:30:23');
/*!40000 ALTER TABLE `phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(2,1,4,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(3,2,1,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(4,3,2,'2012-10-11 11:30:05','2012-10-11 11:30:05'),(5,4,3,'2012-10-11 11:30:05','2012-10-11 11:30:05');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_role_unique` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2012-10-11 11:30:05','2012-10-11 11:30:05'),(2,'user','2012-10-11 11:30:05','2012-10-11 11:30:05'),(3,'guest','2012-10-11 11:30:05','2012-10-11 11:30:05'),(4,'super','2012-10-11 11:30:05','2012-10-11 11:30:05');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Prasanna Bhat','prasanna.yoga@gmail.com','$2a$08$Q1RhWTVUYnJIMGpXVHRMeOCjGsKJM/oeqFBClvFg9OzfGBqG/FLhm','2012-10-11 11:30:05','2012-10-11 11:30:05'),(2,'Amruta Prasanna','amruta.pune@gmail.com','$2a$08$UmFCcGNIYXlRZFN2VGxVaOuYAGqgW/Hcu0dkwTx.kBrT.snUlnSEi','2012-10-11 11:30:05','2012-10-11 11:30:05'),(3,'Krishnamurthy','krish@gmail.com','$2a$08$TkdCazZhaElIeW1jMmp3aOq8.Zqafe7P9r206hvF.Nc24QlG2P1vq','2012-10-11 11:30:05','2012-10-11 11:30:05'),(4,'Gautam','gautam@gmail.com','$2a$08$dENxTkdzZTB4eEZpeTFFTO2X2OXz39vom9o67JPWFZWlMHFgm7NGq','2012-10-11 11:30:05','2012-10-11 11:30:05'),(5,'gautam Chakraborthy','gautam.d8@gmail.org',NULL,'2012-10-15 08:37:37','2012-10-15 10:15:23'),(6,'Sriram S N','sriram@gmail.com',NULL,'2012-10-22 10:05:02','2012-10-22 10:05:02'),(7,'Arup Mukherjee','',NULL,'2012-10-23 11:30:23','2012-10-23 11:30:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-24 14:02:55
