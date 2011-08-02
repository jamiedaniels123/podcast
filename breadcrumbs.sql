-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: podcast
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

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
-- Table structure for table `breadcrumbs`
--

DROP TABLE IF EXISTS `breadcrumbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breadcrumbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breadcrumbs`
--

LOCK TABLES `breadcrumbs` WRITE;
/*!40000 ALTER TABLE `breadcrumbs` DISABLE KEYS */;
INSERT INTO `breadcrumbs` VALUES (1,NULL,NULL,0,'2011-06-20 10:55:18','2011-06-20 10:55:18','Home','/'),(2,'users','dashboard',0,'2011-06-20 10:56:00','2011-06-20 10:56:00','Dashboard','/users/dashboard'),(3,'podcasts','index',2,'2011-06-20 11:11:21','2011-06-20 11:11:21','Collections','/podcasts'),(4,'podcasts','view',3,'2011-06-20 11:22:18','2011-06-20 11:22:18','View',''),(5,'podcasts','edit',3,'2011-06-20 11:22:44','2011-06-20 11:22:44','Edit',''),(6,'podcasts','add',3,'2011-06-20 11:23:12','2011-06-20 11:23:12','Create',''),(7,'podcasts','approve_index',3,'2011-06-20 11:24:50','2011-06-20 11:24:50','Podcasts Waiting Approval','/approve/podcasts'),(8,'user_groups','index',2,'2011-06-20 11:26:34','2011-06-20 11:26:34','Your User Groups','/user_groups'),(9,'user_groups','view',8,'2011-06-20 11:27:17','2011-06-20 11:27:17','View',''),(10,'user_groups','edit',8,'2011-06-20 11:28:05','2011-06-20 11:28:05','Edit',''),(11,'user_groups','add',8,'2011-06-20 11:29:09','2011-06-20 11:29:09','Create',''),(15,'users','admin_index',2,'2011-06-20 14:48:21','2011-06-20 14:48:21','User Administration','/admin/users'),(16,'users','admin_edit',15,'0000-00-00 00:00:00','0000-00-00 00:00:00','Edit',''),(17,'user_groups','admin_index',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','User Group Administration',NULL),(18,'user_groups','admin_add',17,'0000-00-00 00:00:00','0000-00-00 00:00:00','Create','/admin/user_groups/add'),(19,'user_groups','admin_edit',17,'0000-00-00 00:00:00','0000-00-00 00:00:00','Edit',''),(20,'user_groups','admin_view',17,'0000-00-00 00:00:00','0000-00-00 00:00:00','View',''),(21,'podcasts','admin_edit',22,'0000-00-00 00:00:00','0000-00-00 00:00:00','Edit','/admin/podcasts/edit'),(22,'podcasts','admin_index',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','Collections Administration','/admin/podcasts'),(24,'podcasts','admin_add',21,NULL,NULL,'Add','/admin/podcasts/add'),(23,'podcasts','admin_view',21,NULL,NULL,'View','/admin/podcasts/view'),(26,'podcasts','itunes_index',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','iTunes','/itunes/podcasts/index'),(25,'podcasts','youtube_index',2,NULL,NULL,'Youtube','/youtube/podcasts/index');
/*!40000 ALTER TABLE `breadcrumbs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-08-02 11:16:24
