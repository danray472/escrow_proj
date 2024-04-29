-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: escrow_project
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (4,'admin','$2y$10$JpF3BHmEd17K4UiJqEbIae0uJlp7ezhozJXmeqAWOBqQoVu0wqHwS','admin@gmail.com');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,1,10.00,'2024-03-12 13:33:43'),(2,2,1,10.00,'2024-03-12 13:40:25'),(3,4,1,80.00,'2024-03-12 13:40:28'),(4,3,1,50.00,'2024-03-12 13:55:18'),(5,5,1,50.00,'2024-03-12 14:00:02'),(6,4,1,80.00,'2024-03-12 21:09:59'),(7,5,1,50.00,'2024-03-12 21:15:55'),(8,1,1,10.00,'2024-03-12 21:16:19'),(9,10,4,30.00,'2024-03-13 08:00:04'),(10,6,4,10.00,'2024-03-13 14:02:55'),(11,6,4,10.00,'2024-03-13 14:46:49'),(12,6,4,10.00,'2024-03-21 07:20:34'),(13,15,7,80.00,'2024-03-21 07:30:58');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_verification`
--

DROP TABLE IF EXISTS `task_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `verified_by_admin` tinyint(1) DEFAULT 0,
  `verification_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `task_verification_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_verification`
--

LOCK TABLES `task_verification` WRITE;
/*!40000 ALTER TABLE `task_verification` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_verification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `deadline` date NOT NULL,
  `client_id` int(11) NOT NULL,
  `writer_id` int(11) DEFAULT NULL,
  `status` enum('open','assigned','completed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `writer_id` (`writer_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`writer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'easy','narrate the universe story',10.00,'2024-01-02',1,1,'','2024-03-12 11:24:03',0),(2,'easy','reproductive system easy',10.00,'2025-01-01',1,1,'','2024-03-12 11:43:07',0),(3,'easy','data entry',50.00,'2024-01-03',1,1,'','2024-03-12 11:48:30',0),(4,'proposal','describe a MS software project',80.00,'2024-01-05',1,1,'','2024-03-12 13:39:41',0),(5,'data entry','data about number of cars in thinka load/hour',50.00,'2024-03-20',1,1,'','2024-03-12 13:59:26',0),(6,'blog writing','any content',10.00,'2024-03-20',1,4,'','2024-03-12 14:06:16',0),(7,'data entry','data about number of cars in thinka load/hour',50.00,'2024-03-20',1,4,'assigned','2024-03-12 21:13:44',0),(8,'data entry','data about number of cars in thinka load/hour',50.00,'2024-03-20',1,1,'assigned','2024-03-12 21:13:52',0),(9,'content writing','social meadia blog',40.00,'2024-02-03',1,4,'assigned','2024-03-12 21:14:45',0),(10,'easy','write easy about the revolution of man',30.00,'2024-03-05',4,4,'','2024-03-13 07:20:29',0),(11,'easy','world war II story',90.00,'2024-03-31',4,7,'assigned','2024-03-13 07:58:00',0),(12,'content writing','social meadia blog',40.00,'2024-02-03',4,NULL,'open','2024-03-13 12:28:38',0),(13,'blog','blog',10.00,'2456-11-12',4,NULL,'open','2024-03-13 12:29:36',0),(14,'blog','blog',10.00,'2456-11-12',4,NULL,'open','2024-03-21 07:20:14',0),(15,'proposal','describe a MS software project',80.00,'2024-01-05',4,7,'','2024-03-21 07:20:50',0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','writer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'dan','danray472@gmail.com','$2y$10$kZB1lGe4zqwQkX8VW1UccuUN6/5Ig9uHMPozPt0UGbyVwupe7IPyi','client','2024-03-12 11:16:26',0,160.00),(2,'admin','admin@gmail.com','$2y$10$1pK4tY4TEmWCDQh./XASAuUQ5lxKKUIf.vrKLsnPBc1T/Cuqy3QEG','client','2024-03-12 11:57:17',1,0.00),(3,'','','$2y$10$tBNiCf/JUAWb1U.99g5PCOd/ZP3lvcegRUjCfBsKjbRWwweUhf2Gm','client','2024-03-12 21:11:19',0,0.00),(4,'acacia','acacia@gmail.com','$2y$10$zZqaPZOuc9Vpe7eb1lg3/Oe3QTgJwFrNy4jshpV0/R5Rd8WDT.7cu','client','2024-03-12 21:13:00',0,0.00),(5,'','','$2y$10$XZVOFMNiTj5kwq64xxrULuP0vlvBSqSG.ws/ZmGERdoVCiPICtdSC','client','2024-03-21 07:19:37',0,0.00),(6,'','','$2y$10$PjfZleVlpS3dPotrTBb.Bug7GCuUjxlbJ99zRbkCMD59g3kzKDMcW','client','2024-03-21 07:21:50',0,0.00),(7,'dan ray','dan@gmail.com','$2y$10$zY6/AxMuiBSxcjW5.Tx.uO2LC5RbzosJnk.KFxim8icEfvd0QpNra','client','2024-03-21 07:22:43',0,80.00);
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

-- Dump completed on 2024-03-21 21:05:51
