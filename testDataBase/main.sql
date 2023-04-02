CREATE DATABASE  IF NOT EXISTS `main` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `main`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: main
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email as the username',
  `password` varchar(96) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Use password hash with BCRYPT',
  `created` datetime NOT NULL,
  `first_name` varchar(96) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(96) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_70E4FA78F85E0677` (`username`),
  KEY `username_idx` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'maysarah','test1','2018-02-21 12:00:00','Maysarah','Abu Eloun'),(2,'medo','$2y$13$G9QfwEgn52IcIon0tNeRo.MHOSwf9eztgsiZ4yhnK.qIbCEpu3/6C','2023-03-30 14:13:56','Maysarano','Adriano'),(4,'leoda','$2y$13$TY/y/nk1og8Am6gNoBf8ueOwukQ9RaZsR7cuD3UguQOrX7KRVhPDq','2023-03-30 14:37:57','leonardo','da'),(9,'leodaa','$2y$13$EiGd2V3s.sj3umEaFhsCje.NsJxWZrOYK90nT/s1eZw/9TDlqaB5S','2023-03-30 14:49:23','leonardo','da'),(12,'maysarah_2','$2y$13$DkRyWswqVVWeDM7sTX4ACedLcnOVW1jBNjEpNY4O/ahZi58pzs2Ka','2023-04-03 01:41:27','Maysarah','Abu Eloun');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20230330031812','2023-03-30 06:20:43',1),('DoctrineMigrations\\Version20230330185447','2023-03-30 21:58:21',72),('DoctrineMigrations\\Version20230330195607','2023-03-31 01:32:39',19),('DoctrineMigrations\\Version20230330220713','2023-03-31 01:43:34',473);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creator_id` int NOT NULL,
  `vico_id` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2FB3D0EE19F89217` (`vico_id`),
  KEY `creator_idx` (`creator_id`),
  KEY `created_idx` (`created`),
  CONSTRAINT `FK_2FB3D0EE19F89217` FOREIGN KEY (`vico_id`) REFERENCES `vico` (`id`),
  CONSTRAINT `FK_2FB3D0EE61220EA6` FOREIGN KEY (`creator_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,1,1,'2018-02-21 12:00:00','test'),(2,2,1,'2023-03-30 17:03:48','new test'),(3,2,NULL,'2023-03-30 17:04:03','new test'),(4,2,NULL,'2023-03-30 17:14:05','new test'),(5,2,NULL,'2023-03-30 17:14:36','new test'),(6,2,NULL,'2023-03-30 22:51:33','new test'),(7,12,NULL,'2023-04-03 01:49:13','maysarah_test');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_ratings`
--

DROP TABLE IF EXISTS `project_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_ratings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `rating_type_id` int unsigned NOT NULL,
  `rating` smallint NOT NULL,
  `client_note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_58A80BAC166D1F9C` (`project_id`),
  KEY `IDX_58A80BAC260075EB` (`rating_type_id`),
  CONSTRAINT `FK_58A80BAC166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `FK_58A80BAC260075EB` FOREIGN KEY (`rating_type_id`) REFERENCES `rating_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_ratings`
--

LOCK TABLES `project_ratings` WRITE;
/*!40000 ALTER TABLE `project_ratings` DISABLE KEYS */;
INSERT INTO `project_ratings` VALUES (2,1,4,5,'new test','2023-03-30 06:20:43','2023-03-30 06:20:43'),(3,2,3,4,'this is a new test from upate','2023-03-31 04:46:54','2023-03-31 04:46:54'),(4,2,3,0,'postman test','2023-03-31 04:47:11','2023-03-31 04:47:11'),(5,2,3,4,'new update','2023-03-31 04:50:13','2023-03-31 04:50:13'),(6,5,5,4,'new update','2023-03-31 05:39:40','2023-03-31 05:39:40'),(7,2,4,5,NULL,'2023-03-31 15:29:10','2023-03-31 15:29:10'),(29,2,5,3,NULL,'2023-03-31 15:56:51','2023-03-31 15:56:51'),(30,3,3,4,'this is a new test','2023-03-31 15:57:38','2023-03-31 15:57:38'),(31,3,5,3,NULL,'2023-03-31 15:57:38','2023-03-31 15:57:38'),(32,3,4,5,NULL,'2023-03-31 15:57:38','2023-03-31 15:57:38');
/*!40000 ALTER TABLE `project_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating_types`
--

DROP TABLE IF EXISTS `rating_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rating_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C426860C77153098` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_types`
--

LOCK TABLES `rating_types` WRITE;
/*!40000 ALTER TABLE `rating_types` DISABLE KEYS */;
INSERT INTO `rating_types` VALUES (3,'OVERALL','Overall Satisfaction','2023-03-30 23:04:44'),(4,'COMM','Communication','2023-03-30 23:06:31'),(5,'QOW','Quality Of Work','2023-03-30 23:08:03'),(8,'VFM','Value For Money','2023-03-31 00:22:22'),(9,'OVERALL','Overall Satisfaction','2023-04-03 01:52:22'),(10,'OVERALL','Overall Satisfaction','2023-04-03 01:52:25');
/*!40000 ALTER TABLE `rating_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vico`
--

DROP TABLE IF EXISTS `vico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name_idx` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vico`
--

LOCK TABLES `vico` WRITE;
/*!40000 ALTER TABLE `vico` DISABLE KEYS */;
INSERT INTO `vico` VALUES (1,'leonardo','2023-03-30 14:57:47'),(2,'kww','2023-03-30 15:13:43'),(3,'kww','2023-03-30 15:14:46');
/*!40000 ALTER TABLE `vico` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-03  2:30:26
