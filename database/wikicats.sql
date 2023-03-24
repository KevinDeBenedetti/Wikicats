-- MySQL dump 10.13  Distrib 8.0.32, for macos12.6 (x86_64)
--
-- Host: localhost    Database: wikicats
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cats`
--

DROP TABLE IF EXISTS `cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `certified` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cats`
--

LOCK TABLES `cats` WRITE;
/*!40000 ALTER TABLE `cats` DISABLE KEYS */;
INSERT INTO `cats` VALUES (7,'Bernard','bernard@minou.fr','$2y$10$Zm5SJTtcMDtk7AsX0.z5LuotM2n.Bh9FiwEKy4uEdFl8zszbU13wy',1),(8,'Miam','miam@cat.cr','$2y$10$VJ1a1w157BRN1ZxIoCP.SOtGMQyiINEsETU0ovqQX.8e4NcEd55.2',1),(9,'Miaous','miaous@pokemon.pk','$2y$10$HBzL.pl2xXir8tDmRgfC5OjzkR3j87pRIe2WKjTwaDVqYnRNs7YYe',1),(10,'Catman','catman@catman.cat','$2y$10$.s5hYW5zoF3tWbwIa/LFgePCZRcHev8dswVJhOc8MKfS1b7zLC50u',1),(11,'Chat','chat@chat.fr','$2y$10$qclrFW3mGulp6zNBCEfif.T537WmXop15r7hdw/9BxM4ljRNEYY0a',1);
/*!40000 ALTER TABLE `cats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `cat_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `content` text NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_comments_cats` (`cat_id`),
  KEY `fk_comments_topics` (`topic_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (3,NULL,7,5,'OK','2023-03-23 10:17:20'),(6,NULL,7,5,'Trop doux.','2023-03-23 10:26:31'),(7,NULL,7,5,'fgsebbgyr','2023-03-23 10:27:12'),(8,NULL,7,5,'hetytet','2023-03-23 10:27:40'),(9,NULL,7,5,'Super topic, je vais réfléchir ...','2023-03-23 10:59:27'),(10,NULL,7,5,'Dans le sens des oreilles','2023-03-23 11:01:11'),(11,NULL,8,5,'Bien vue Bernard, sujet très intéressant ! ','2023-03-23 11:21:49'),(12,NULL,7,5,'Test','2023-03-23 12:39:43'),(13,NULL,7,5,'Test','2023-03-23 12:42:41'),(25,13,7,5,'Un petite tests de réponses','2023-03-23 21:35:03'),(26,NULL,7,7,'Pour être en bonne santé un chat adulte doit faire au moins 2km pour ne pas avoir de bidou','2023-03-23 21:37:46'),(27,26,9,7,'2km c&#39;est beaucoup, pour moi c&#39;est 200m par jour pas plus','2023-03-23 21:40:16'),(30,13,9,5,'Une réponse pour pierre','2023-03-24 08:09:37'),(32,NULL,7,11,'Quel est le dress code pour cette semaine ? ','2023-03-24 12:12:55'),(33,32,10,11,'Ce sera BDSM pour ce soir','2023-03-24 12:17:03'),(34,NULL,11,11,'S&#39;il pleut ce sera en extérieur ? ','2023-03-24 13:20:52'),(35,32,11,11,'Trop cool le thème ! ','2023-03-24 13:24:40'),(36,34,7,11,'On pourra aller dans une des salles du Greta au premier, si une fenêtre est ouverte ce sera un jeu de chaton','2023-03-24 13:28:48');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_topics_cats` (`cat_id`),
  CONSTRAINT `fk_topics_cats` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `cats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (5,7,'Dans quel sens lécher son pelage','A mon humble miaou, tout dépend du pelage du félin. Le sens dépend aussi de la longueur de la langue du minou','Toilettage','2023-03-23 08:56:35'),(7,7,'La marche à 4 pattes','Quelle distance parcourir chaque jour pour être en bonne santé ? ','Santé','2023-03-23 13:20:24'),(9,10,'Étirement sur un plaid tout doux','Tous les matins je libère dégourdi mes petites pattes en faisant du yoga plaid. Quel bonheur ! Vous en pensez quoi ?','Yoga','2023-03-24 11:13:15'),(10,10,'Les insectes du sud est','Une liste des meilleurs insectes à manger en milieu rural','Chasse','2023-03-24 12:07:48'),(11,10,'Les rendez-vous du vendredi soir à Arles','Comme d\'habitude pour les minous avertis, nos rencontres se dérouleront au village des entreprises dans le parc ou les humains déjeunent.','Rencontres libertines','2023-03-24 12:09:53'),(12,7,'Attraper des oiseaux de jour','Auriez vous des conseils pour mieux chasser le jour, car perso j\'y vois beaucoup moins bien et c\'est un peu galère','Chasse','2023-03-24 13:30:21');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-24 15:00:16
