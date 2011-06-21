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
-- Table structure for table `access_levels`
--

DROP TABLE IF EXISTS `access_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_levels` (
  `al` tinyint(4) NOT NULL DEFAULT '0',
  `access_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`al`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Access levels and staff roles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_levels`
--

LOCK TABLES `access_levels` WRITE;
/*!40000 ALTER TABLE `access_levels` DISABLE KEYS */;
INSERT INTO `access_levels` VALUES (9,'System administrator'),(1,'Student'),(2,'Supervisor'),(5,'Discipline administrator'),(6,'Faculty administrator'),(8,'Administrator'),(4,'Research secretary'),(7,'Podcast Author');
/*!40000 ALTER TABLE `access_levels` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breadcrumbs`
--

LOCK TABLES `breadcrumbs` WRITE;
/*!40000 ALTER TABLE `breadcrumbs` DISABLE KEYS */;
INSERT INTO `breadcrumbs` VALUES (1,NULL,NULL,0,'2011-06-20 10:55:18','2011-06-20 10:55:18','Home','/'),(2,'users','dashboard',0,'2011-06-20 10:56:00','2011-06-20 10:56:00','Dashboard','/users/dashboard'),(3,'podcasts','index',2,'2011-06-20 11:11:21','2011-06-20 11:11:21','Collections','/podcasts'),(4,'podcasts','view',3,'2011-06-20 11:22:18','2011-06-20 11:22:18','View',''),(5,'podcasts','edit',3,'2011-06-20 11:22:44','2011-06-20 11:22:44','Edit',''),(6,'podcasts','add',3,'2011-06-20 11:23:12','2011-06-20 11:23:12','Create',''),(7,'podcasts','approve_index',3,'2011-06-20 11:24:50','2011-06-20 11:24:50','Podcasts Waiting Approval','/approve/podcasts'),(8,'user_groups','index',2,'2011-06-20 11:26:34','2011-06-20 11:26:34','Your User Groups','/user_groups'),(9,'user_groups','view',8,'2011-06-20 11:27:17','2011-06-20 11:27:17','View',''),(10,'user_groups','edit',8,'2011-06-20 11:28:05','2011-06-20 11:28:05','Edit',''),(11,'user_groups','add',8,'2011-06-20 11:29:09','2011-06-20 11:29:09','Create',''),(15,'users','admin_index',2,'2011-06-20 14:48:21','2011-06-20 14:48:21','User Administration','/admin/users'),(16,'users','admin_edit',15,'0000-00-00 00:00:00','0000-00-00 00:00:00','Edit',''),(17,'user_groups','admin_index',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','User Group Administration',NULL),(18,'user_groups','admin_add',17,'0000-00-00 00:00:00','0000-00-00 00:00:00','Create','/admin/user_groups/add'),(19,'user_groups','admin_edit',17,'0000-00-00 00:00:00','0000-00-00 00:00:00','Edit',''),(20,'user_groups','admin_view',17,'0000-00-00 00:00:00','0000-00-00 00:00:00','View',NULL),(21,'podcasts','admin_edit',21,'0000-00-00 00:00:00','0000-00-00 00:00:00','Edit','/admin/podcasts/edit'),(22,'podcasts','admin_index',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','Collections Administration','/admin/podcasts'),(24,'podcasts','admin_add',21,NULL,NULL,'Add','/admin/podcasts/add'),(23,'podcasts','admin_view',21,NULL,NULL,'View','/admin/podcasts/view');
/*!40000 ALTER TABLE `breadcrumbs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) NOT NULL DEFAULT '0',
  `category` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1 COMMENT='iTunes podcast categories';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,'Arts'),(2,0,'Business'),(3,0,'Comedy'),(4,0,'Education'),(5,0,'Games & Hobbies'),(6,0,'Government & Organizations'),(7,0,'Health'),(8,0,'Kids & Family'),(9,0,'Music'),(10,0,'News & Politics'),(11,0,'Religion & Spirituality'),(12,0,'Science & Medicine'),(13,0,'Society & Culture'),(14,0,'Sports & Recreation'),(15,0,'Technology'),(16,0,'TV & Film'),(17,1,'Design'),(18,1,'Fashion & Beauty'),(19,1,'Food'),(20,1,'Literature'),(21,1,'Performing Arts'),(22,1,'Visual Arts'),(23,2,'Business News'),(24,2,'Careers'),(25,2,'Investing'),(26,2,'Management & Market'),(27,2,'Shopping'),(28,4,'Education Technology'),(29,4,'Higher Education'),(30,4,'K-12'),(31,4,'Language Courses'),(32,4,'Training'),(33,5,'Automotive'),(34,5,'Aviation'),(35,5,'Hobbies'),(36,5,'Other Games'),(37,5,'Video Games'),(38,6,'Local'),(39,6,'National'),(40,6,'Non-Profit'),(41,6,'Regional'),(42,7,'Alternative Health'),(43,7,'Fitness & Nutrition'),(44,7,'Self-Help'),(45,7,'Sexuality'),(46,11,'Buddhism'),(47,11,'Christianity'),(48,11,'Hinduism'),(49,11,'Islam'),(50,11,'Judaism'),(51,11,'Other'),(52,11,'Spirituality'),(53,12,'Medicine'),(54,12,'Natural Sciences'),(55,12,'Social Sciences'),(56,13,'History'),(57,13,'Personal Journals'),(58,13,'Philosophy'),(59,13,'Places & Travel'),(60,14,'Amateur'),(61,14,'College & High School'),(62,14,'Outdoor'),(63,14,'Professional'),(64,15,'Gadgets'),(65,15,'Tech News'),(66,15,'Podcasting'),(67,15,'Software How-To');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feed_hits_log`
--

DROP TABLE IF EXISTS `feed_hits_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_hits_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feed` mediumint(8) unsigned DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `response` smallint(6) NOT NULL DEFAULT '200',
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1103 DEFAULT CHARSET=latin1 COMMENT='Log of hits on XML files';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed_hits_log`
--

LOCK TABLES `feed_hits_log` WRITE;
/*!40000 ALTER TABLE `feed_hits_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `feed_hits_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itunesu_categories`
--

DROP TABLE IF EXISTS `itunesu_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itunesu_categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(12) DEFAULT NULL,
  `code_title` varchar(32) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=latin1 COMMENT='iTunes U Categories';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itunesu_categories`
--

LOCK TABLES `itunesu_categories` WRITE;
/*!40000 ALTER TABLE `itunesu_categories` DISABLE KEYS */;
INSERT INTO `itunesu_categories` VALUES (1,'100','Business',0),(2,'100100','Economics',1),(3,'100101','Finance',1),(4,'100102','Hospitality',1),(5,'100103','Management',1),(6,'100104','Marketing',1),(7,'100105','Personal Finance',1),(8,'100106','Real Estate',1),(9,'101','Engineering',0),(10,'101100','Chemical & Petroleum',1),(11,'101101','Civil',1),(12,'101102','Computer Science',1),(13,'101103','Electrical',1),(14,'101104','Environmental',1),(15,'101105','Mechanical',1),(16,'102','Fine Arts',0),(17,'102100','Architecture',1),(18,'102101','Art',1),(19,'102102','Art History',1),(20,'102103','Dance',1),(21,'102104','Film',1),(22,'102105','Graphic Design',1),(23,'102106','Interior Design',1),(24,'102107','Music',1),(25,'102108','Theater',1),(26,'103','Health & Medicine',0),(27,'103100','Anatomy & Physiology',1),(28,'103101','Behavioral Science',1),(29,'103102','Dentistry',1),(30,'103103','Diet & Nutrition',1),(31,'103104','Emergency',1),(32,'103105','Genetics',1),(33,'103106','Gerontology',1),(34,'103107','Health & Exercise Science',1),(35,'103108','Immunology',1),(36,'103109','Neuroscience',1),(37,'103110','Pharmacology & Toxicology',1),(38,'103111','Psychiatry',1),(39,'103112','Public Health',1),(40,'103113','Radiology',1),(41,'104','History',0),(42,'104100','Ancient',1),(43,'104101','Medieval',1),(44,'104102','Military',1),(45,'104103','Modern',1),(46,'104104','African',1),(47,'104105','Asian',1),(48,'104106','European',1),(49,'104107','Middle Eastern',1),(50,'104108','North American',1),(51,'104109','South American',1),(52,'105','Humanities',0),(53,'105100','Communications',1),(54,'105101','Philosophy',1),(55,'105102','Religion',1),(56,'106','Language',0),(57,'106100','African',1),(58,'106101','Ancient',1),(59,'106102','Asian',1),(60,'106103','Eastern European/Slavic',1),(61,'106104','English',1),(62,'106105','English Language Learners',1),(63,'106106','French',1),(64,'106107','German',1),(65,'106108','Italian',1),(66,'106109','Linguistics',1),(67,'106110','Middle Eastern',1),(68,'106111','Spanish & Portuguese',1),(69,'106112','Speech Pathology',1),(70,'107','Literature',0),(71,'107100','Anthologies',1),(72,'107101','Biography',1),(73,'107102','Classics',1),(74,'107103','Criticism',1),(75,'107104','Fiction',1),(76,'107105','Poetry',1),(77,'108','Mathematics',0),(78,'108100','Advanced Mathematics',1),(79,'108101','Algebra',1),(80,'108102','Arithmetic',1),(81,'108103','Calculus',1),(82,'108104','Geometry',1),(83,'108105','Statistics',1),(84,'109','Science',0),(85,'109100','Agricultural',1),(86,'109101','Astronomy',1),(87,'109102','Atmospheric',1),(88,'109103','Biology',1),(89,'109104','Chemistry',1),(90,'109105','Ecology',1),(91,'109106','Geography',1),(92,'109107','Geology',1),(93,'109108','Physics',1),(94,'110','Social Science',0),(95,'110100','Law',1),(96,'110101','Political Science',1),(97,'110102','Public Administration',1),(98,'110103','Psychology',1),(99,'110104','Social Welfare',1),(100,'110105','Sociology',1),(101,'111','Society',0),(102,'111100','African-American Studies',1),(103,'111101','Asian Studies',1),(104,'111102','European & Russian Studies',1),(105,'111103','Indigenous Studies',1),(106,'111104','Latin & Caribbean Studies',1),(107,'111105','Middle Eastern Studies',1),(108,'111106','Women\'s Studies',1),(109,'112','Teaching & Education',0),(110,'112100','Curriculum & Teaching',1),(111,'112101','Educational Leadership',1),(112,'112102','Family & Childcare',1),(113,'112103','Learning Resources',1),(114,'112104','Psychology & Research',1),(115,'112105','Special Education',1);
/*!40000 ALTER TABLE `itunesu_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `lang_code` varchar(6) NOT NULL DEFAULT '',
  `language` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`lang_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Languages';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES ('en-gb','English (GB)'),('es','Spanish'),('it','Italian'),('fr','French'),('en','English'),('en-us','English (US)'),('de','German');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_hits_log`
--

DROP TABLE IF EXISTS `media_hits_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_hits_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feed` mediumint(8) unsigned DEFAULT NULL,
  `item_id` mediumint(8) unsigned DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `response` smallint(6) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=569 DEFAULT CHARSET=latin1 COMMENT='Log of hits on feed items';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_hits_log`
--

LOCK TABLES `media_hits_log` WRITE;
/*!40000 ALTER TABLE `media_hits_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_hits_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node_links`
--

DROP TABLE IF EXISTS `node_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `node_links` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL,
  `child_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node_links`
--

LOCK TABLES `node_links` WRITE;
/*!40000 ALTER TABLE `node_links` DISABLE KEYS */;
INSERT INTO `node_links` VALUES (1,1,5),(2,1,6),(3,1,7),(4,1,8),(5,1,9),(6,1,10),(7,1,11),(8,1,12),(9,1,13),(10,1,14),(11,1,15),(12,1,16),(13,1,17),(14,1,18),(15,1,19),(16,6,20),(17,18,21),(18,6,22),(19,18,24),(20,5,25),(40,12,34),(39,14,33),(38,5,33),(37,11,32),(36,19,31),(35,12,30),(34,9,29),(33,13,28),(32,19,27),(31,8,26),(41,10,35),(42,10,36),(43,18,36),(44,10,37),(45,9,38),(46,14,39),(47,19,40),(48,18,41),(49,14,42),(50,6,43),(51,10,43),(52,5,44),(53,5,45),(54,5,46),(55,13,46),(56,18,46),(57,13,47),(58,18,47),(59,13,48),(60,12,49),(61,10,50),(62,5,52),(63,16,53),(64,11,54),(65,16,54),(66,5,55),(67,19,55),(68,14,56),(69,5,57),(70,13,58),(71,11,59),(72,11,60),(73,5,61),(74,18,62),(75,19,63),(76,19,65),(77,13,66),(78,18,66),(79,5,67),(80,13,68),(81,19,69),(82,19,70),(83,13,71),(84,14,72),(85,13,73),(86,16,74),(87,6,75),(88,8,75),(89,12,75),(90,12,76),(91,6,77),(92,12,77),(93,9,78),(94,0,1),(95,0,2),(96,0,3),(97,0,4);
/*!40000 ALTER TABLE `node_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nodes`
--

DROP TABLE IF EXISTS `nodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nodes` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `endnode` set('Y','N') NOT NULL DEFAULT 'N',
  `title` varchar(150) DEFAULT NULL,
  `description` text,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hide` set('N','Y') NOT NULL DEFAULT 'N',
  `subject_code` varchar(16) DEFAULT NULL,
  `subject_url_name` varchar(150) DEFAULT NULL,
  `openlearn_url` varchar(150) DEFAULT NULL COMMENT 'Mapping from blue list to OpenLearn; initially used for YouTube migration',
  `use_of_subject` varchar(150) DEFAULT NULL,
  `banner_image` varchar(150) DEFAULT NULL,
  `course_image` varchar(150) DEFAULT NULL,
  `added_by` varchar(24) DEFAULT NULL,
  `added_when` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1 COMMENT='Nodes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nodes`
--

LOCK TABLES `nodes` WRITE;
/*!40000 ALTER TABLE `nodes` DISABLE KEYS */;
INSERT INTO `nodes` VALUES (1,0,'N','OU Learn','Want to get a qualification that will help you develop or change your career? Learn a subject in depth? The Open University â€“ voted top for student satisfaction for three years running â€“ could provide the flexibility, the qualifications and the top-class teaching you\'re after. For most courses you don\'t need any previous qualifications. And with our world-leading blend of supported open learning and innovative course materials, you\'ll get an exceptional learning experience.',0,'N','OULRN','oulearn','http://www.open.ac.uk/openlearn/',NULL,NULL,NULL,NULL,NULL),(2,0,'N','OU Research','The founding Chancellor of the Open University, Lord Crowther, proclaimed that The Open University would be open as to people, open as to places and open as to methods and ideas, and this holds true as much for our distinctive research as it does for our teaching methods.',0,'N','OURES','ouresearch','http://www.open.ac.uk/openlearn/',NULL,NULL,NULL,NULL,NULL),(3,0,'N','OU Life','Our mission \r\nThe Open University is open to people, places, methods and ideas. It promotes educational opportunity and social justice by providing high-quality university education to all who wish to realise their ambitions and fulfil their potential. Through academic research, pedagogic innovation and collaborative partnership it seeks to be a world leader in the design, content and delivery of supported open and distance learning.',0,'N','OULIFE','oulife','http://www.open.ac.uk/openlearn/',NULL,NULL,NULL,NULL,NULL),(4,0,'N','OU Faculties','Podcasts on a wide variety of subjects recorded for the Faculties and Departments of the Open University.',0,'Y',NULL,'oufaculties','http://www.open.ac.uk/openlearn/',NULL,NULL,NULL,NULL,NULL),(5,1,'N','Arts and Humanities','Arts and Humanities encompass subjects that are all concerned with cultural expression and how it has come to take the forms that exist today. They include Art History; Classical Studies; English; History (incorporating History of Science, Technology and Medicine); Music; Philosophy; Religious Studies; African and Asian Studies; and Comparative Criminological Research. Studying in the arts and humanities enables you to explore human culture and its history, from the ancient civilisations of Greece and Rome through the Renaissance, to the twenty-first century. In the process you will gain important analytical and critical skills needed for a wide range of occupations.',1,'N','AHU   ','arts-and-humanities','http://www.open.ac.uk/openlearn/history-the-arts',NULL,NULL,NULL,NULL,NULL),(6,1,'N','Business and Management','Our highly-respected business and management courses will allow you to develop and extend your knowledge, skills and practice â€“ whether youâ€™re looking for a one-off piece of professional updating or a qualification: 75 per cent of the FTSE 100 companies have sponsored OU students. We offer foundation degrees in Business, or Leadership & Management, and a major new Business Studies certificate. You can study accounting, economics, French, ICT, law, Spanish or systems practice as part of our innovative and well-respected Business Studies degree, or use our specialist courses in finance and accounting to provide a route into the accounting profession. ',1,'N','BMA   ','business-and-management','http://www.open.ac.uk/openlearn/money-management ',NULL,NULL,NULL,NULL,NULL),(7,1,'N','The Open Programme','An Open degree is a BA or BSc degree where you choose the courses and subjects that you study. As an alternative to a degree in a named subject, such as computing or history, the Open degree lets you create a degree that\'s tailored to your own requirements.',1,'Y','BOP   ','open-programme',NULL,NULL,NULL,NULL,NULL,NULL),(8,1,'N','Computing and ICT','Virtually everything we do involves information and communication technologies (ICTs) â€“ from booking tickets online and emailing friends, to paying by credit card and using household appliances. At the heart of ICTs are computers â€“ ranging from microprocessors in mobile phones, through personal computers, to large internet servers and mainframes. Most of us simply take these technologies for granted, yet understanding how they work is fascinating. Whether you simply have an enquiring mind, or want to learn more about this fast growing field in order to change career direction or improve your prospects, the OU offers a wide range of courses.',1,'N','CIT   ','computing-and-ict','http://www.open.ac.uk/openlearn/science-maths-technology/computing-and-ict ',NULL,NULL,NULL,NULL,NULL),(9,1,'N','Childhood and Youth','Looking at the world from a childâ€™s or young personâ€™s point of view isnâ€™t always easy. If you want to work with children or young people we offer a wide choice of one-off courses and qualifications that cover the full age range and can help your career. Start slowly, if it suits, and go as far as you need. We offer certificates and degrees from the early years through adolescence to young adulthood. By studying with us you can increase your awareness of what it really means for children growing up in todayâ€™s world, and become more effective in your role.',1,'N','CYS   ','childhood-and-youth','http://www.open.ac.uk/openlearn/body-mind/childhood-youth ',NULL,NULL,NULL,NULL,NULL),(10,1,'N','Environment, Development and International Studies','Climate change, global trade, war, cultural conflict, biodiversity, energy, water and food sourcing, poverty and the challenges of international development are among the defining features of our times. With our courses and qualifications you can explore some of the most challenging trends and developments that are shaping our world and the individuals who inhabit it. You\'ll become a more enlightened citizen. And on a professional level you could make a real difference with your highly valued skills, which could lead to many exciting career options in policy making, corporate responsibility or environmental services.',1,'N','EDI   ','environment-development-and-international-studies','http://www.open.ac.uk/openlearn/nature-environment/the-environment ',NULL,NULL,NULL,NULL,NULL),(11,1,'N','Education','Education offers the exciting prospect of making a difference. Itâ€™s important both for individual success and societyâ€™s continuing development. With the changes now taking place to widen participation and strengthen teaching and learning at all levels, education is â€“ more than ever â€“ a dynamic, challenging and rewarding sector to be involved in. The OU has been delivering education courses for over 25 years and now offers a wide range of professional and undergraduate qualifications for practicing teachers, plus general courses to help you support your own child in school. ',1,'N','EDU   ','education','http://www.open.ac.uk/openlearn/education',NULL,NULL,NULL,NULL,NULL),(12,1,'N','Engineering and Technology','If you enjoy solving problems and have a good imagination youâ€™ll find engineering and technology stimulating and challenging fields of study. Our cutting-edge range of courses enable you to explore how innovation, design, engineering technology, systems and people interact. A qualification in any of these areas can lead to exciting career opportunities in business and industry, as well as in the public and voluntary sectors in the UK and further afield. Employers value highly the numerical skills, creativity, scientific knowledge and team-working experience that engineering and technology graduates possess.',1,'N','ETE   ','engineering-and-technology','http://www.open.ac.uk/openlearn/science-maths-technology/engineering-and-technology ',NULL,NULL,NULL,NULL,NULL),(13,1,'N','Health and Social Care','Health and social care is a vast service sector undergoing rapid change, with new government initiatives giving it a higher profile than ever. Priorities on the healthcare agenda include being more responsive to patient needs, and preventing illness by promoting a healthy lifestyle. The focus in frontline health and social care is on giving service-users more independence, choice and control. These developments mean thereâ€™s greater demand for well-trained and multi-skilled people across a range of rewarding employment opportunities. Our courses cover topics ranging from health sciences, health studies, nursing, public health, social care, social work and sport and fitness.',1,'N','HSC   ','health-and-social-care','http://www.open.ac.uk/openlearn/body-mind ',NULL,NULL,NULL,NULL,NULL),(14,1,'N','Languages','Do you want to communicate in another language? Gain an insight into other cultures? Maybe you regret not having pursued language studies at school? Or perhaps language skills will get you the job of your dreams? In our increasingly global economy, being able to communicate effectively with our customers, colleagues and business partners is critical. Learning a modern language is also enjoyable and rewarding. We offer courses in French, German, Spanish, Italian and Welsh and a number of courses about the English language, its history and how it has changed in response to different cultural, social, technological and geographical pressures.',1,'N','LAN   ','languages','http://www.open.ac.uk/openlearn/languages',NULL,NULL,NULL,NULL,NULL),(15,1,'N','Law','Law is a foundation stone of society and plays an increasingly important and visible role in virtually all areas of modern life. Social and environmental responsibilities, business operations and international codes of conduct are all determined and upheld by legal systems. We offer a range of degree programmes and short courses in law to a very wide variety of people from all areas of life. Our courses have been praised by senior judges, eminent lawyers and internationally acclaimed legal academics. For the last two years our law degree has been ranked within the top six in the National Student Survey.',1,'N','LAW   ','law','http://www.open.ac.uk/openlearn/society/the-law',NULL,NULL,NULL,NULL,NULL),(16,1,'N','Mathematics and Statistics','Mathematics and statistics play a part in almost all daily activities. They are at the heart of advances in science and technology, as well as providing indispensable problem-solving and decision-making tools in many areas of life. They underpin the rigorous analysis and modelling required for new policies, designs and systems. Mathematical and statistical knowledge is much sought after by employers for a wide variety of jobs, not least in teaching the subject, and a qualification in any one of the areas we offer can bring real benefits in your professional life.',1,'N','MST   ','mathematics-and-statistics','http://www.open.ac.uk/openlearn/science-maths-technology/mathematics-and-statistics',NULL,NULL,NULL,NULL,NULL),(17,1,'N','Psychology','Weâ€™re all interested in what makes people tick, how they think, act and interact with others. Thatâ€™s why studying psychology â€“ the science of human behavior â€“ is interesting in its own right. But it can also help develop a range of widely applicable transferable skills.  As well as gaining an understanding of ideas, theories and methods in psychology, and learning how to analyze and evaluate psychological concepts, you will develop skills in assessing different kinds of evidence, including both quantitative and qualitative data leading to opportunities in education, industry, the health professions, management, advertising and marketing, human resources, research, counseling, and social services.',1,'N','PSY   ','psychology','http://www.open.ac.uk/openlearn/body-mind/psychology',NULL,NULL,NULL,NULL,NULL),(18,1,'N','Science','The more you look into science, the more fascinating it becomes. Advances in areas such as communications, food production, health care and transport all depend on fresh knowledge emerging from scienceâ€™s many disciplines. Studying science will enhance your understanding of the world, and contribute to your intellectual and personal development. The depth and breadth of our courses encompass topics such as biology, chemistry, earth and environmental science, geology, physics, and planetary and space sciences (including astronomy).',1,'N','SCI   ','science','http://www.open.ac.uk/openlearn/science-maths-technology/science',NULL,NULL,NULL,NULL,NULL),(19,1,'N','Social Sciences','Many social science subjects provide fascinating insights into everyday life in our communities, families and workplaces. Topics include criminology, economics, geography, media studies, politics, psychology, social policy and sociology. In our courses youâ€™ll engage with some of the most compelling and contested questions in contemporary society: How do we communicate with each other? Why do places carry meaning for people? What are our rights as citizens? What shapes our identity and why? Our courses will stimulate your curiosity, encourage you to ask questions and challenge assumptions, and help you understand yourself â€“ and the world we live in â€“ more deeply.',1,'N','SSC   ','social-sciences','http://www.open.ac.uk/openlearn/society ',NULL,NULL,NULL,NULL,NULL),(20,1,'N','Accounting and Finance',NULL,2,'N','ACCFIN','accounting-and-finance',NULL,NULL,NULL,NULL,NULL,NULL),(21,1,'N','Biology',NULL,2,'N','BIOL  ','biology',NULL,NULL,NULL,NULL,NULL,NULL),(22,1,'N','Business Management Studies',NULL,2,'N','BMSTU ','business-management-studies',NULL,NULL,NULL,NULL,NULL,NULL),(23,1,'N','The Open Programme',NULL,2,'N','BOP   ','open-programme',NULL,NULL,NULL,NULL,NULL,NULL),(24,1,'N','Chemistry',NULL,2,'N','CHEM  ','chemistry',NULL,NULL,NULL,NULL,NULL,NULL),(25,1,'N','Classical Studies',NULL,2,'N','CLSSTU','classical-studies',NULL,NULL,NULL,NULL,NULL,NULL),(26,1,'N','Computing',NULL,2,'N','COMP  ','computing',NULL,NULL,NULL,NULL,NULL,NULL),(27,1,'N','Criminology',NULL,2,'N','CRIM  ','criminology',NULL,NULL,NULL,NULL,NULL,NULL),(28,1,'N','Children and Young People',NULL,2,'N','CYP   ','children-and-young-people',NULL,NULL,NULL,NULL,NULL,NULL),(29,1,'N','Childhood and Youth Studies',NULL,2,'N','CYSTU ','childhood-and-youth-studies',NULL,NULL,NULL,NULL,NULL,NULL),(30,1,'N','Design and Innovation',NULL,2,'N','DESINN','design-and-innovation',NULL,NULL,NULL,NULL,NULL,NULL),(31,1,'N','Economics',NULL,2,'N','ECON  ','economics',NULL,NULL,NULL,NULL,NULL,NULL),(32,1,'N','Educational Technology and Practice',NULL,2,'N','EDUTP ','educational-technology-and-practice',NULL,NULL,NULL,NULL,NULL,NULL),(33,1,'N','English Language',NULL,2,'N','ENGLAN','english-language',NULL,NULL,NULL,NULL,NULL,NULL),(34,1,'N','Engineering',NULL,2,'N','ENGN  ','engineering',NULL,NULL,NULL,NULL,NULL,NULL),(35,1,'N','Environmental Decision Making',NULL,2,'N','ENVDM ','environmental-decision-making',NULL,NULL,NULL,NULL,NULL,NULL),(36,1,'N','Environmental Science',NULL,2,'N','ENVSCI','environmental-science',NULL,NULL,NULL,NULL,NULL,NULL),(37,1,'N','Environmental Studies',NULL,2,'N','ENVSTU','environmental-studies',NULL,NULL,NULL,NULL,NULL,NULL),(38,1,'N','Early Years',NULL,2,'N','EY    ','early-years',NULL,NULL,NULL,NULL,NULL,NULL),(39,1,'N','French',NULL,2,'N','FREN  ','french',NULL,NULL,NULL,NULL,NULL,NULL),(40,1,'N','Geography',NULL,2,'N','GEOG  ','geography',NULL,NULL,NULL,NULL,NULL,NULL),(41,1,'N','Geology','Why do earthquakes occur where they do? How is gold formed? What shapes the landscape? How did dinosaurs become extinct? If youâ€™re intrigued by the Earthâ€™s structure, composition and development over time, studying geology with the OU will feed your interest and imagination.',2,'N','GEOL  ','geology',NULL,NULL,NULL,NULL,NULL,NULL),(42,1,'N','German',NULL,2,'N','GERM  ','german',NULL,NULL,NULL,NULL,NULL,NULL),(43,1,'N','Global Development Management',NULL,2,'N','GLOBDM','global-development-management',NULL,NULL,NULL,NULL,NULL,NULL),(44,1,'N','History',NULL,2,'N','HIS   ','history',NULL,NULL,NULL,NULL,NULL,NULL),(45,1,'N','History of Art',NULL,2,'N','HISART','history-of-art',NULL,NULL,NULL,NULL,NULL,NULL),(46,1,'N','History of Science, Technology and Medicine',NULL,2,'N','HISSTM','history-of-science-technology-and-medicine',NULL,NULL,NULL,NULL,NULL,NULL),(47,1,'N','Health Sciences',NULL,2,'N','HTHSCI','health-sciences',NULL,NULL,NULL,NULL,NULL,NULL),(48,1,'N','Health Studies',NULL,2,'N','HTHSTU','health-studies',NULL,NULL,NULL,NULL,NULL,NULL),(49,1,'N','Information and Communication Technologies',NULL,2,'N','ICT   ','ict',NULL,NULL,NULL,NULL,NULL,NULL),(50,1,'N','International Studies',NULL,2,'N','INTSTU','international-studies',NULL,NULL,NULL,NULL,NULL,NULL),(51,1,'N','Law',NULL,2,'N','LAW   ','law',NULL,NULL,NULL,NULL,NULL,NULL),(52,1,'N','Literature and Creative Writing',NULL,2,'N','LITCW ','literature-and-creative-writing',NULL,NULL,NULL,NULL,NULL,NULL),(53,1,'N','Mathematics',NULL,2,'N','MATH  ','mathematics',NULL,NULL,NULL,NULL,NULL,NULL),(54,1,'N','Mathematics Education',NULL,2,'N','MATHED','mathematics-education',NULL,NULL,NULL,NULL,NULL,NULL),(55,1,'N','Media Studies',NULL,2,'N','MEDSTU','media-studies',NULL,NULL,NULL,NULL,NULL,NULL),(56,1,'N','More Languages',NULL,2,'N','MORLAN','more-languages',NULL,NULL,NULL,NULL,NULL,NULL),(57,1,'N','Music',NULL,2,'N','MUS   ','music',NULL,NULL,NULL,NULL,NULL,NULL),(58,1,'N','Nursing',NULL,2,'N','NURS  ','nursing',NULL,NULL,NULL,NULL,NULL,NULL),(59,1,'N','Professional Development in Education',NULL,2,'N','PDE   ','professional-development-in-education',NULL,NULL,NULL,NULL,NULL,NULL),(60,1,'N','PGCE',NULL,2,'N','PGCE  ','pgce',NULL,NULL,NULL,NULL,NULL,NULL),(61,1,'N','Philosophy','Everyone thinks about the meaning of life from time to time. But studying philosophy gives you the opportunity to ponder the big questions. What is reality? Do emotions conflict with reason? How do we reconcile different world views? The OUâ€™s philosophy programme is based broadly on the Anglo-American tradition and gives you a choice of different study options.',2,'N','PHIL  ','philosophy',NULL,NULL,NULL,NULL,NULL,NULL),(62,1,'N','Physics and Astronomy',NULL,2,'N','PHYAST','physics-and-astronomy',NULL,NULL,NULL,NULL,NULL,NULL),(63,1,'N','Politics',NULL,2,'N','POL   ','politics',NULL,NULL,NULL,NULL,NULL,NULL),(64,1,'N','Psychology',NULL,2,'N','PSY   ','psychology',NULL,NULL,NULL,NULL,NULL,NULL),(65,1,'N','Psychological Studies',NULL,2,'N','PSYSTU','psychological-studies',NULL,NULL,NULL,NULL,NULL,NULL),(66,1,'N','Public Health',NULL,2,'N','PUBHTH','public-health',NULL,NULL,NULL,NULL,NULL,NULL),(67,1,'N','Religious Studies',NULL,2,'N','RELSTU','religious-studies',NULL,NULL,NULL,NULL,NULL,NULL),(68,1,'N','Social Care',NULL,2,'N','SOCARE','social-care',NULL,NULL,NULL,NULL,NULL,NULL),(69,1,'N','Sociology',NULL,2,'N','SOCY  ','sociology',NULL,NULL,NULL,NULL,NULL,NULL),(70,1,'N','Social Policy',NULL,2,'N','SOPOLY','social-policy',NULL,NULL,NULL,NULL,NULL,NULL),(71,1,'N','Social Work',NULL,2,'N','SOWORK','social-work',NULL,NULL,NULL,NULL,NULL,NULL),(72,1,'N','Spanish',NULL,2,'N','SPAN  ','spanish',NULL,NULL,NULL,NULL,NULL,NULL),(73,1,'N','Sport and Fitness',NULL,2,'N','SPOFIT','sport-and-fitness',NULL,NULL,NULL,NULL,NULL,NULL),(74,1,'N','Statistics',NULL,2,'N','STAT  ','statistics',NULL,NULL,NULL,NULL,NULL,NULL),(75,1,'N','Systems',NULL,2,'N','SYST  ','systems',NULL,NULL,NULL,NULL,NULL,NULL),(76,1,'N','Technology',NULL,2,'N','TECH  ','technology',NULL,NULL,NULL,NULL,NULL,NULL),(77,1,'N','Technology Management',NULL,2,'N','TECHMA','technology-management',NULL,NULL,NULL,NULL,NULL,NULL),(78,1,'N','Working with Young People',NULL,2,'N','WYP   ','working-with-young-people',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_item_media`
--

DROP TABLE IF EXISTS `podcast_item_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_item_media` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `podcast_item` mediumint(8) unsigned NOT NULL,
  `media_type` set('default','3gp','audio-mp3','audio-m4a','audio-m4b','desktop','hd','iphone','iphonecellular','ipod','large','transcript','youtube','extra','ipod-all','desktop-all','high','epub') NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `duration` float(12,4) NOT NULL,
  `uploaded_by` varchar(24) NOT NULL,
  `uploaded_when` datetime NOT NULL,
  `processed_state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `podcast_item` (`podcast_item`,`media_type`)
) ENGINE=MyISAM AUTO_INCREMENT=54411 DEFAULT CHARSET=latin1 COMMENT='List of media files by ''media type'' associated with a given ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_item_media`
--

LOCK TABLES `podcast_item_media` WRITE;
/*!40000 ALTER TABLE `podcast_item_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_item_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_items`
--

DROP TABLE IF EXISTS `podcast_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_items` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned DEFAULT NULL COMMENT 'Link to podcasts record',
  `shortcode` varchar(12) DEFAULT NULL COMMENT 'Unique code for this track',
  `sub_feed` varchar(24) NOT NULL COMMENT 'used to create sub-feeds of a podcast, particularly with iTunes U in mind where you may have multiple ''tabs'' of different content in one ''album'' (podcast)',
  `subsection` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'ID of the subsection this item appears in',
  `youtube_flag` set('N','Y') NOT NULL DEFAULT 'N',
  `itunes_flag` set('N','Y') NOT NULL DEFAULT 'N',
  `openlearn_explore_flag` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Used to indicate if the item should appear within the RSS feed provided to OpenLearn Explore website',
  `short_title` varchar(80) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `youtube_description` text,
  `summary` text NOT NULL,
  `author` varchar(150) NOT NULL DEFAULT '',
  `explicit` set('yes','no','clean') NOT NULL DEFAULT 'no',
  `original_filename` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `fileformat` varchar(24) DEFAULT NULL,
  `duration` float(12,4) DEFAULT NULL COMMENT 'In seconds',
  `status` varchar(24) DEFAULT NULL COMMENT 'Legacy - believed not used',
  `published_flag` set('N','Y') NOT NULL DEFAULT 'N',
  `uploaded_by` varchar(24) DEFAULT NULL COMMENT 'Legacy',
  `uploaded_when` datetime DEFAULT NULL COMMENT 'Legacy',
  `processed_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Reported by transcoding servers',
  `youtube_id` varchar(64) DEFAULT NULL COMMENT 'This field is populated with the youtube unique id if this track has been uploaded to YouTube',
  `youtube_legacy_track` set('N','Y') DEFAULT 'N' COMMENT 'Used to define YouTube tracks which have not been uploaded via the PPodcast publishing system and thus do not have the relevant tracking tags',
  `created_by` varchar(24) DEFAULT NULL,
  `created_when` datetime DEFAULT NULL,
  `last_modified_by` varchar(24) DEFAULT NULL,
  `last_modified_when` datetime DEFAULT NULL,
  `publication_date` datetime DEFAULT NULL COMMENT 'Date this track will appear live',
  `auto_publish_flag` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Set to make track appear live automatically',
  `transcript_filename` varchar(100) DEFAULT NULL,
  `transcript_upload_by` varchar(24) DEFAULT NULL,
  `transcript_upload_when` datetime DEFAULT NULL,
  `image_filename` varchar(100) DEFAULT NULL,
  `image_upload_by` varchar(24) DEFAULT NULL,
  `image_upload_when` datetime DEFAULT NULL,
  `prod_id` varchar(15) DEFAULT NULL,
  `archive_details` text,
  `music_details` text,
  `cover_art_suggestions` text,
  `tape_ref` varchar(15) DEFAULT NULL,
  `epub_isbn` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'ISBN number if an eBook',
  `epub_study_hours` smallint(8) NOT NULL DEFAULT '0',
  `epub_study_level` varchar(20) DEFAULT NULL,
  `source_media` varchar(15) DEFAULT NULL,
  `aspect_ratio` float(4,2) DEFAULT NULL,
  `time_code` text,
  `first_use_date` datetime DEFAULT NULL,
  `episode` varchar(15) DEFAULT NULL,
  `closed_caption` varchar(15) DEFAULT NULL,
  `prod_status` varchar(15) DEFAULT NULL,
  `unit_course` varchar(15) DEFAULT NULL,
  `unit_course_title` varchar(100) DEFAULT NULL,
  `youtube_channel` varchar(100) DEFAULT NULL COMMENT 'Actually YouTube subject category',
  `topic_category` varchar(200) DEFAULT NULL,
  `itunes_genre` varchar(100) DEFAULT NULL,
  `itunes_album` varchar(100) DEFAULT NULL,
  `target_url` varchar(200) DEFAULT NULL,
  `target_url_text` varchar(150) DEFAULT NULL COMMENT 'Text for item-level link',
  `youtube_tags` text,
  `itunes_tags` text,
  `geo_location` varchar(30) DEFAULT NULL,
  `producer_owner` varchar(40) DEFAULT NULL,
  `academic_consultant` text,
  `credits` text,
  `rights_issues` text,
  `rights_approved` text COMMENT 'Free text providing details of rights approval',
  `acknowledgements` text,
  `notes` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12519 DEFAULT CHARSET=latin1 COMMENT='Items for podcasts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_items`
--

LOCK TABLES `podcast_items` WRITE;
/*!40000 ALTER TABLE `podcast_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_links`
--

DROP TABLE IF EXISTS `podcast_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_links` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` mediumint(8) unsigned NOT NULL,
  `podcast_id` mediumint(8) unsigned NOT NULL,
  `primary` set('N','Y') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5067 DEFAULT CHARSET=latin1 COMMENT='LInks between nodes and podcasts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_links`
--

LOCK TABLES `podcast_links` WRITE;
/*!40000 ALTER TABLE `podcast_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_related_urls`
--

DROP TABLE IF EXISTS `podcast_related_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_related_urls` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned DEFAULT NULL,
  `link_url` varchar(150) DEFAULT NULL,
  `link_text` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1 COMMENT='Related links for podcasts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_related_urls`
--

LOCK TABLES `podcast_related_urls` WRITE;
/*!40000 ALTER TABLE `podcast_related_urls` DISABLE KEYS */;
INSERT INTO `podcast_related_urls` VALUES (3,222,'http://kmi.open.ac.uk/','The Knowledge Media Institute at The Open University'),(2,222,'http://cnm.open.ac.uk/','The Centre for New Media, KMi'),(4,222,'http://news.bbc.co.uk/1/hi/uk/default.stm','BBC News for the UK'),(5,222,'http://dev.mysql.com/doc/refman/5.0/en/pattern-matching.html','MySQL provides standard SQL pattern matching as well as a form of pattern matching based on extended regular expressions similar to those used by Unix utilities such as vi, grep, and sed.'),(7,371,'http://www.open2.net/savingbritainspast/index.html','Saving Britain\'s Past'),(8,372,'http://www.open2.net/savingbritainspast/index.html','Saving Britain\'s Past'),(9,373,'http://www.open2.net/savingbritainspast/index.html','Saving Britain\'s Past'),(10,374,'http://www.open2.net/savingbritainspast/index.html','Saving Britain\'s Past'),(11,458,'http://www.lambethpalacelibrary.org.uk/content/buildingonhistory','Building on History: The Church in London | LAMBETH PALACE LIBRARY'),(12,458,'http://www.kcl.ac.uk/','Kingâ€™s College London'),(13,458,'http://www.london.anglican.org/','Diocese of London (Church of England)'),(14,458,'http://www.ahrc.ac.uk/Pages/default.aspx','Arts and Humanities Research Council [AHRC]'),(15,458,'http://www.open.ac.uk/research/?LKCAMPAIGN=it001_gen&MEDIA=it001_research','OU Research'),(21,467,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(17,473,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(18,473,'http://darwin.britishcouncil.org/','Darwin Now'),(19,474,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(20,474,'http://darwin.britishcouncil.org/','Darwin Now'),(22,467,'http://darwin.britishcouncil.org/','Darwin Now'),(23,468,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(24,468,'http://darwin.britishcouncil.org/','Darwin Now'),(25,469,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(26,469,'http://darwin.britishcouncil.org/','Darwin Now'),(27,470,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(28,470,'http://darwin.britishcouncil.org/','Darwin Now'),(29,471,'http://www.open.ac.uk/darwin/','Charles Darwin at The Open University'),(30,471,'http://darwin.britishcouncil.org/','Darwin Now'),(31,478,'http://www.scitech.ac.uk/','Science and Technology Facilities Council'),(32,502,'http://bit.ly/aOt85C','Highest resolution version'),(33,502,'http://compendium.open.ac.uk/institute','Compendium knowledge mapping tool'),(34,230,'http://www.open.ac.uk/platform','Platform'),(35,588,'http://www.open.ac.uk/library','Open University Library Services'),(36,618,'http://library.open.ac.uk','The Open University Library'),(37,662,'http://www.open.ac.uk/blogs/sociallearn/2010/06/22/learning-in-an-open-world-session/','Blog post with slides and commentary'),(38,802,'http://www.youtube.com/watch?v=J3aV2eH8u6M','Youtube link'),(39,801,'http://podcast.open.ac.uk/pod/vc-message-to-staff','The Vice Chancellor\'s messages to staff (original video podcast)'),(40,481,'http://podcast.open.ac.uk/pod/vc-message-to-staff-audio','The Vice Chancellor\'s messages to staff (audio only version of podcast)'),(41,1023,'http://www.opened.ac.uk','SCORE web-site'),(42,1107,'http://www.opened.ac.uk','SCORE web-site'),(43,1136,'http://www8.open.ac.uk/researchprojects/historyofou/','History of the OU website');
/*!40000 ALTER TABLE `podcast_related_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_subsections`
--

DROP TABLE IF EXISTS `podcast_subsections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_subsections` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned DEFAULT NULL COMMENT 'Cross-link to podcasts table',
  `subsection` tinyint(3) unsigned DEFAULT NULL COMMENT 'Number for order',
  `sub_feed` varchar(50) DEFAULT NULL COMMENT 'Short name',
  `subsection_name` varchar(200) DEFAULT NULL COMMENT 'Long descriptive name',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COMMENT='Podcast subsection titles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_subsections`
--

LOCK TABLES `podcast_subsections` WRITE;
/*!40000 ALTER TABLE `podcast_subsections` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_subsections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_tags`
--

DROP TABLE IF EXISTS `podcast_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_tags` (
  `podcast_id` mediumint(9) NOT NULL DEFAULT '0',
  `tag_id` mediumint(9) NOT NULL DEFAULT '0',
  KEY `podcast_id` (`podcast_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_tags`
--

LOCK TABLES `podcast_tags` WRITE;
/*!40000 ALTER TABLE `podcast_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_youtube_queue`
--

DROP TABLE IF EXISTS `podcast_youtube_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_youtube_queue` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned NOT NULL,
  `track_id` mediumint(8) unsigned NOT NULL,
  `youtube_channel` varchar(100) DEFAULT NULL COMMENT 'Name of YouTube channel to upload to',
  `queued_by` varchar(16) DEFAULT NULL COMMENT 'User who added this track to the queue',
  `queued_when` datetime DEFAULT NULL COMMENT 'When added to the queue',
  `uploaded_when` datetime DEFAULT NULL COMMENT 'Timestamp movie was actually uploaded to YouTube',
  `done_flag` set('N','Y','P','F') NOT NULL DEFAULT 'N',
  `error_code` tinyint(4) NOT NULL DEFAULT '0',
  `error_text` text COMMENT 'Error text returned from YouTube',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Queue of files to upload to YouTube';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_youtube_queue`
--

LOCK TABLES `podcast_youtube_queue` WRITE;
/*!40000 ALTER TABLE `podcast_youtube_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcast_youtube_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcasts`
--

DROP TABLE IF EXISTS `podcasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcasts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `grouping` varchar(24) NOT NULL COMMENT 'for podcasts imported from spreadsheet; called unique id on podcast form',
  `title` varchar(255) DEFAULT NULL COMMENT 'Podcast title',
  `summary` text COMMENT 'Podcast description',
  `image` varchar(150) DEFAULT NULL COMMENT 'Normal podcast image file',
  `image_copyright` varchar(150) NOT NULL,
  `image_source` varchar(255) NOT NULL,
  `image_logoless` varchar(150) DEFAULT NULL COMMENT 'Logoless image file for OpenLearn',
  `image_ll_copyright` varchar(150) DEFAULT NULL COMMENT 'Copyright or credit for logoless image',
  `image_wide` varchar(150) DEFAULT NULL COMMENT 'Wide format image',
  `image_wide_copyright` varchar(150) DEFAULT NULL COMMENT 'Copyright or credit for wide image',
  `artwork_file` varchar(100) DEFAULT NULL COMMENT 'ZIP archive of podcast artwork for Apple',
  `author` varchar(255) DEFAULT NULL,
  `itunes_u_url` varchar(200) DEFAULT NULL COMMENT 'iTunes unique URL',
  `language` varchar(50) NOT NULL DEFAULT 'en',
  `explicit` set('yes','no','clean') NOT NULL DEFAULT 'no',
  `keywords` text COMMENT 'Comma-delimited',
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `subtitle` text,
  `link` varchar(250) DEFAULT NULL COMMENT 'Related website URL',
  `link_text` varchar(50) DEFAULT NULL COMMENT 'Related website title or description',
  `course_code` varchar(12) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL COMMENT 'Copyright statement for entire podcast',
  `rss_url` varchar(150) DEFAULT NULL COMMENT 'Populated with remote RSS URL for agregating content - legacy funcationality that is no longer supported but this field is tested in the code',
  `custom_id` varchar(50) DEFAULT NULL COMMENT 'Custom feed name; forms part of URL',
  `private` set('N','Y') NOT NULL DEFAULT 'N',
  `intranet_only` set('N','Y') NOT NULL DEFAULT 'N',
  `media_location` set('local','s3nonOU','s3all') NOT NULL DEFAULT 'local' COMMENT 'Location of media files',
  `publish_itunes_u` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Flag indicates whether the podcast is publish to iTunes U',
  `publish_itunes_date` date DEFAULT NULL COMMENT 'Date the podcast was published to iTunes U',
  `update_itunes_date` date DEFAULT NULL COMMENT 'Date of last update on iTunes U',
  `intended_itunesu_flag` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y if this podcast intended for iTunesU',
  `openlearn_epub` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'This flag used to indicate that the Collection contains ePub(s) from OpenLearn',
  `itunesu_site` set('public','private') DEFAULT 'public',
  `target_itunesu_date` date DEFAULT NULL COMMENT 'Date of intended launch in iTunesU',
  `production_date` date DEFAULT NULL COMMENT 'Date of production',
  `rights_date` date DEFAULT NULL COMMENT 'Date rights approved',
  `metadata_date` date DEFAULT NULL COMMENT 'Date metadata completed',
  `publish_youtube` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Flag indicates whether the podcast is publish to YouTube',
  `youtube_channel` varchar(50) DEFAULT NULL COMMENT 'Which YouTube channel to upload tracks to',
  `valid_feed` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Legacy code - no longer used',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Legacy? Looks unused.',
  `owner_id` int(5) NOT NULL,
  `podcast_flag` tinyint(1) DEFAULT '0',
  `intended_youtube_flag` set('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1455 DEFAULT CHARSET=latin1 COMMENT='Podcasts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcasts`
--

LOCK TABLES `podcasts` WRITE;
/*!40000 ALTER TABLE `podcasts` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcasts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcasts_categories`
--

DROP TABLE IF EXISTS `podcasts_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcasts_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcasts_categories`
--

LOCK TABLES `podcasts_categories` WRITE;
/*!40000 ALTER TABLE `podcasts_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcasts_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcasts_itunesu_categories`
--

DROP TABLE IF EXISTS `podcasts_itunesu_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcasts_itunesu_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `itunesu_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcasts_itunesu_categories`
--

LOCK TABLES `podcasts_itunesu_categories` WRITE;
/*!40000 ALTER TABLE `podcasts_itunesu_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `podcasts_itunesu_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queues`
--

DROP TABLE IF EXISTS `queues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queues` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `data` text,
  `attempts` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Queue of jobs to be sent to the API';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queues`
--

LOCK TABLES `queues` WRITE;
/*!40000 ALTER TABLE `queues` DISABLE KEYS */;
/*!40000 ALTER TABLE `queues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tag_text` varchar(150) DEFAULT NULL,
  `preferred` set('N','Y') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `tag` (`tag_text`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'Business and management','Y'),(2,'Education and teacher training','Y'),(3,'Health and social care/Health studies','Y'),(4,'Humanities: arts, languages, history','Y'),(5,'Information technology and computing','Y'),(6,'Law and criminology','Y'),(7,'Mathematics and statistics','Y'),(8,'Psychology, philosophy, politics, economics','Y'),(9,'Science','Y'),(10,'Social sciences','Y'),(11,'Technology, engineering and manufacturing','Y'),(12,'Continuing Professional Development','N'),(13,'developer_test','N');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp`
--

DROP TABLE IF EXISTS `temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp` (
  `autoid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uniqueid` mediumint(9) DEFAULT NULL,
  `oldid` mediumint(8) unsigned DEFAULT NULL COMMENT 'The old section number',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temporary table for renumbering podcast subsections';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp`
--

LOCK TABLES `temp` WRITE;
/*!40000 ALTER TABLE `temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_podcasts`
--

DROP TABLE IF EXISTS `user_group_podcasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group_podcasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `podcast_id` int(11) NOT NULL,
  `moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_podcasts`
--

LOCK TABLES `user_group_podcasts` WRITE;
/*!40000 ALTER TABLE `user_group_podcasts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group_podcasts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `group_title` varchar(50) DEFAULT NULL,
  `members` text NOT NULL,
  `created_by` varchar(16) NOT NULL,
  `created_when` datetime NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COMMENT='User group definitions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'KMi','(964,1)','cpv2','2008-04-16 20:08:34',NULL,NULL),(2,'iTunes U Team','(1096,2,1063,999,1,998,1100)','cpv2','2008-04-16 20:58:41',NULL,NULL),(3,'Communications','(932,953,1015,951,939,952,950)','cpv2','2008-04-16 20:59:06',NULL,NULL),(4,'OUBS','(977,1064,1065,1050)','cpv2','2008-04-24 14:39:33',NULL,NULL),(5,'Science','(944,948,1)','bh6','2008-08-11 19:56:06',NULL,NULL),(6,'Platform','(932,953,1015,951,939,952,950)','bh6','2008-10-08 16:08:27',NULL,NULL),(7,'IET','(1023,956,954,955,989,1,1056)','bh6','2008-10-17 12:39:00',NULL,NULL),(13,'OpenLearn Explore','(953,1008,1007,1000,984)','bh6','2009-11-09 17:51:09',NULL,NULL),(8,'LTS-Podcast','(960,968,935,966,937,934)','bh6','2008-11-16 23:56:20',NULL,NULL),(19,'LDT','(1001,1067,1029,1090)','bh6','2010-08-09 16:36:17',NULL,NULL),(9,'LTS-HSC','(967,937,968)','bh6','2009-04-22 15:23:51',NULL,NULL),(10,'CRC','(983,982)','bh6','2009-07-31 04:23:32',NULL,'2011-05-12 13:10:02'),(11,'IET-Lab','(986,970,989,971)','cpv2','2009-09-24 16:27:58',NULL,NULL),(15,'Documentum','(1038,1049,1050,1019,1012)','cpv2','2010-06-18 12:46:53',NULL,NULL),(16,'Library','(957,945,1021)','bh6','2010-07-13 18:22:41',NULL,NULL),(17,'OLnet','(1026,1023)','cpv2','2010-07-28 08:44:45',NULL,NULL),(18,'OUBS-Website','(1027,1068,1028,1005,1050,1064,1065,1030,1083,1082)','bh6','2010-07-30 04:09:52',NULL,NULL),(20,'Open Broadcasting Unit','(934,1033,1031,1097)','bh6','2010-08-17 04:26:31',NULL,NULL),(21,'OHSD','(1035,1058,1034,1059,1050)','cpv2','2010-09-01 09:00:00',NULL,NULL),(22,'Marketing Intranet','(1038,1036,1050,1037,1012)','bh6','2010-09-03 04:53:21',NULL,NULL),(23,'LTS-Mobile-site','(1010,933)','bh6','2010-10-13 00:49:29',NULL,NULL),(24,'LTS-Unison','(1045,1053,1010,1062)','bh6','2010-11-08 17:00:49',NULL,NULL),(25,'Learning Innovation Office','(933,1056,936)','cpv2','2010-11-11 11:10:37',NULL,NULL),(26,'Online Marketing','(1046,1047)','bh6','2010-12-10 15:27:03',NULL,NULL),(27,'Podcast Workshop','(1069,1070,1071,1073,1074,1075,1076,1077,1078,1079,1072,990)','bh6','2011-01-27 14:43:52',NULL,NULL),(28,'T156 Production','(1091,974,934,983)','bh6','2011-03-07 02:34:58',NULL,NULL),(29,'Social Science - Research Project Oecumene','(1093,1024,1094)','bh6','2011-03-10 05:41:58',NULL,NULL),(30,'PSE2010','(937,1100)','bh6','2011-03-28 04:41:55',NULL,NULL),(32,'OUAV','(947,1048)','bh6','2011-04-08 17:46:49',NULL,NULL),(33,'Social Sciences - Research project - ICCM','(1024,1104,1105,1106,1107)','cpv2','2011-04-18 10:40:35',NULL,NULL),(99,'XXXXXXXXXXXXXXX','','','0000-00-00 00:00:00','2011-06-01 11:19:28','2011-06-03 23:09:20'),(78,'SAsA','','','0000-00-00 00:00:00','2011-05-12 11:28:39','2011-05-12 11:28:52');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_podcasts`
--

DROP TABLE IF EXISTS `user_podcasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_podcasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `podcast_id` int(11) NOT NULL,
  `moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_podcasts`
--

LOCK TABLES `user_podcasts` WRITE;
/*!40000 ALTER TABLE `user_podcasts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_podcasts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_user_groups`
--

DROP TABLE IF EXISTS `user_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_user_groups`
--

LOCK TABLES `user_user_groups` WRITE;
/*!40000 ALTER TABLE `user_user_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_title` varchar(12) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `accessLevel` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `iTunesU` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Can this user access iTunesU',
  `YouTube` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Can this user access YouTube',
  `openlearn_explore` set('Y','N') NOT NULL DEFAULT 'N',
  `oucu` varchar(16) DEFAULT NULL,
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `administrator` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `terms` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1116 DEFAULT CHARSET=latin1 COMMENT='Users table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','Chris','Valentine','c.p.valentine@open.ac.uk',9,'Y','Y','Y','cpv2','2010-11-10 09:13:03','2011-04-21 15:30:15',0,NULL,0,1),(2,'','Ben','Hawkridge','b.hawkridge@open.ac.uk',9,'Y','Y','N','bh6','2007-12-07 15:41:00','2011-04-29 03:59:44',0,NULL,0,1),(932,NULL,'Stuart','Brown','s.a.brown@open.ac.uk',7,'N','N','N','sab668','0000-00-00 00:00:00','2011-04-18 10:24:41',0,NULL,0,1),(933,NULL,'Rhodri','Thomas','rhodri.thomas@open.ac.uk',7,'N','N','N','rt536','0000-00-00 00:00:00','2011-04-13 15:29:38',0,NULL,0,1),(934,NULL,'John','Sinton','j.sinton@open.ac.uk',7,'N','N','N','js7','0000-00-00 00:00:00','2011-04-26 15:59:16',0,NULL,0,1),(935,NULL,'Matthew','Holley','m.j.holley@open.ac.uk',7,'N','N','N','mh6338','0000-00-00 00:00:00','2011-04-05 15:44:53',0,NULL,0,1),(936,NULL,'Kevin','Mayles','k.i.mayles@open.ac.uk',7,'N','N','N','kim25','0000-00-00 00:00:00','2011-04-28 17:08:12',0,NULL,0,1),(937,NULL,'Pete','Mitton','p.r.mitton@open.ac.uk',7,'N','N','N','prm96','0000-00-00 00:00:00','2011-04-27 10:47:48',0,NULL,0,1),(938,NULL,'Armelle','Griffin','a.c.griffin@open.ac.uk',7,'N','N','N','acg249','0000-00-00 00:00:00','2011-04-13 14:48:24',0,NULL,0,1),(939,NULL,'Matt','Rawlinson','m.a.rawlinson@open.ac.uk',7,'N','N','N','mar69','0000-00-00 00:00:00','2011-04-05 11:03:30',0,NULL,0,1),(940,NULL,'Kevin','Church','k.d.church@open.ac.uk',7,'N','N','N','kdc2','0000-00-00 00:00:00','2011-04-20 15:07:43',0,NULL,0,1),(941,NULL,'Laurian','Gridinoc','l.gridinoc@open.ac.uk',7,'Y','Y','N','lg4465','0000-00-00 00:00:00','2010-07-15 23:42:40',0,NULL,0,1),(944,NULL,'Louise','Patel','l.r.patel@open.ac.uk',7,'N','N','N','lh2356','0000-00-00 00:00:00','2010-12-10 15:51:41',0,NULL,0,1),(945,NULL,'Keren','Mills','k.mills@open.ac.uk',7,'N','N','N','km3927','0000-00-00 00:00:00','2011-04-27 09:36:03',0,NULL,0,1),(946,NULL,'Peter','Scott','peter.scott@open.ac.uk',7,'N','N','N','pjs33','0000-00-00 00:00:00','2011-04-15 09:58:04',0,NULL,0,1),(947,NULL,'Keith','Hamilton','k.d.hamilton@open.ac.uk',7,'N','N','N','kdh2','0000-00-00 00:00:00','2011-04-20 16:35:58',0,NULL,0,1),(948,NULL,'Emily','Unell','e.j.unell@open.ac.uk',7,'N','N','N','eju7','0000-00-00 00:00:00','2009-01-13 16:32:15',0,NULL,0,1),(949,'','Media','Channel-User','',7,'N','N','N','mcu7','0000-00-00 00:00:00','2010-02-26 05:28:26',0,NULL,0,1),(950,NULL,'Robyn','Bateman','r.l.bateman@open.ac.uk',7,'N','N','N','rls256','0000-00-00 00:00:00','2011-04-27 08:30:17',0,NULL,0,1),(951,NULL,'Jane','Matthews','j.k.matthews@open.ac.uk',7,'N','N','N','jkm5','0000-00-00 00:00:00','2011-02-07 08:39:05',0,NULL,0,1),(952,NULL,'Ian','Roddis','i.roddis@open.ac.uk',7,'N','N','N','ir42','0000-00-00 00:00:00','2011-04-14 15:59:58',0,NULL,0,1),(953,NULL,'Tracy','Buchanan','t.l.buchanan@open.ac.uk',7,'N','N','N','tla42','0000-00-00 00:00:00','2011-03-02 16:59:39',0,NULL,0,1),(954,NULL,'Patrina','Law','p.j.law@open.ac.uk',7,'N','N','N','pjl264','0000-00-00 00:00:00','2011-03-08 10:44:12',0,NULL,0,1),(955,NULL,'Anna','Page','a.c.page@open.ac.uk',7,'N','N','N','acp2','0000-00-00 00:00:00','2011-04-20 11:33:30',0,NULL,0,1),(956,NULL,'Graham','Healing','g.healing@open.ac.uk',7,'N','N','N','ghh44','0000-00-00 00:00:00','2011-04-13 14:47:03',0,NULL,0,1),(957,NULL,'Sam','Dick','s.j.dick@open.ac.uk',7,'N','N','N','sjd275','0000-00-00 00:00:00','2011-04-15 11:51:37',0,NULL,0,1),(958,NULL,'Tony','Law','adl225@tutor.open.ac.uk',7,'N','N','N','adl225','0000-00-00 00:00:00','2010-12-21 10:29:04',0,NULL,0,1),(959,'','Keith','Beechener','k.m.beechener@open.ac.uk',7,'N','N','N','kmb69','0000-00-00 00:00:00','2010-12-10 15:49:52',0,NULL,0,1),(960,NULL,'Dan','Beckwith','d.beckwith@open.ac.uk',7,'N','N','N','db6922','0000-00-00 00:00:00','2009-04-17 09:54:52',0,NULL,0,1),(962,NULL,'Robert','Janes','r.janes@open.ac.uk',7,'N','N','N','rj83','0000-00-00 00:00:00','2011-04-14 16:01:38',0,NULL,0,1),(963,NULL,'Barry','Norton','b.j.norton@open.ac.uk',7,'N','N','N','bjn48','0000-00-00 00:00:00','2009-04-08 19:27:57',0,NULL,0,1),(964,NULL,'John','Domingue','j.b.domingue@open.ac.uk',7,'N','N','N','jbd2','0000-00-00 00:00:00','2011-02-04 17:33:03',0,NULL,0,1),(965,NULL,'Sam','Leicester','s.c.leicester@open.ac.uk',7,'N','N','N','scl239','0000-00-00 00:00:00','2011-04-13 10:52:56',0,NULL,0,1),(966,NULL,'Paul','Hollins','p.a.hollins@open.ac.uk',7,'N','N','N','pah589','0000-00-00 00:00:00','2011-04-13 14:26:41',0,NULL,0,1),(967,NULL,'Adrian','Bickers','a.bickers@open.ac.uk',7,'Y','N','Y','ab23558','0000-00-00 00:00:00','2010-09-23 12:05:34',0,NULL,0,1),(968,NULL,'Ray','Guo','r.guo@open.ac.uk',7,'N','N','N','rg3598','0000-00-00 00:00:00','2011-04-20 16:15:49',0,NULL,0,1),(969,NULL,'Mariano','Rico','m.rico@open.ac.uk',7,'N','N','N','mr2828','2009-04-29 17:39:09','2011-02-11 16:54:28',0,NULL,0,1),(970,NULL,'Kevin','Mcleod','k.mcleod@open.ac.uk',7,'N','N','N','km264','0000-00-00 00:00:00','2011-04-13 13:09:25',0,NULL,0,1),(971,NULL,'William','Woods','w.i.s.woods@open.ac.uk',7,'N','N','N','wisw2','0000-00-00 00:00:00','2011-04-14 08:35:24',0,NULL,0,1),(972,NULL,'Kim','Issroff','k.issroff@open.ac.uk',7,'N','N','N','ki284','0000-00-00 00:00:00','2010-11-02 08:06:37',0,NULL,0,1),(973,NULL,'Gareth','Robins','g.m.robins@open.ac.uk',7,'N','N','N','gmr223','2010-09-01 09:18:44','2011-04-13 14:30:02',0,NULL,0,1),(974,NULL,'Chris','High','c.high@open.ac.uk',7,'N','N','N','ch2972','2009-05-14 19:05:00','2011-04-21 08:33:58',0,NULL,0,1),(975,NULL,'Anna','De Liddo','a.deliddo@open.ac.uk',7,'N','N','N','all94','0000-00-00 00:00:00','2009-11-17 12:36:50',0,NULL,0,1),(976,NULL,'Chris','Williams','chris.williams@open.ac.uk',7,'N','N','N','caw322','2009-06-19 12:13:54','2011-02-07 12:19:33',0,NULL,0,1),(977,NULL,'Dagmara','Rochowski','d.rochowski@open.ac.uk',7,'N','N','N','dr4482','0000-00-00 00:00:00','2011-04-13 15:42:57',0,NULL,0,1),(978,NULL,'Fridolin','Wild','f.wild@open.ac.uk',7,'N','N','N','fw798','0000-00-00 00:00:00','2011-04-26 22:58:09',0,NULL,0,1),(979,NULL,'Mathieu','D\'aquin','m.daquin@open.ac.uk',7,'N','N','N','mda99','0000-00-00 00:00:00','2011-03-28 21:11:45',0,NULL,0,1),(980,NULL,'Tony','O\'shea-Poon','a.f.oshea-poon@open.ac.uk',7,'N','N','N','afos3','2009-07-22 15:33:15','2011-02-08 14:35:35',0,NULL,0,1),(981,'Dr','Simon','Buckingham Shum','s.buckingham.shum@open.ac.uk',7,'N','N','N','sjb72','2009-07-27 18:05:05','2011-03-16 12:50:22',0,NULL,0,1),(982,NULL,'Robert','Seaton','r.w.seaton@open.ac.uk',7,'N','N','N','rws2','0000-00-00 00:00:00','2011-04-13 13:31:42',0,NULL,0,1),(983,NULL,'Joseph','Mills','j.f.mills@open.ac.uk',7,'N','N','N','jfm25','0000-00-00 00:00:00','2011-04-18 11:07:48',0,NULL,0,1),(984,NULL,'Sarah','Lawson','s.lawson@open.ac.uk',7,'N','N','N','sl5684','0000-00-00 00:00:00','2011-04-13 16:02:16',0,NULL,0,1),(985,NULL,'Michelle','Bachler','m.s.bachler@open.ac.uk',7,'N','N','N','msb262','0000-00-00 00:00:00','2011-04-21 12:41:09',0,NULL,0,1),(986,NULL,'Philip','Downs','p.j.downs@open.ac.uk',7,'N','N','N','pjd278','2009-09-18 09:34:46','2011-01-20 17:15:15',0,NULL,0,1),(989,'','David','Perry','d.r.perry@open.ac.uk',7,'N','N','N','drp5','2009-09-24 16:27:17','2011-04-13 13:08:21',0,NULL,0,1),(990,NULL,'Linda','Robson','l.robson@open.ac.uk',7,'N','N','N','lr34','2009-10-02 11:18:41','2011-04-13 16:06:38',0,NULL,0,1),(991,NULL,'Jon','Golding','j.p.golding@open.ac.uk',7,'N','N','N','jpg259','2009-10-02 16:52:11','2011-05-01 11:19:10',0,NULL,0,1),(992,NULL,'Paul','Beeby','p.d.beeby@open.ac.uk',7,'N','N','N','pdb34','2009-10-07 09:47:04','2011-04-21 16:59:19',0,NULL,0,1),(993,NULL,'Grainne','Conole','g.c.conole@open.ac.uk',7,'N','N','N','gcc64','2009-10-07 11:08:23','2010-07-23 16:21:39',0,NULL,0,1),(994,NULL,'Rebecca','Galley','r.galley@open.ac.uk',7,'N','N','N','rg4562','2009-10-07 11:13:26','2011-02-17 14:35:15',0,NULL,0,1),(995,NULL,'Adrian','Leibowitz','a.m.leibowitz@open.ac.uk',7,'N','N','N','aml32','2009-10-22 15:42:54','2011-04-13 13:13:07',0,NULL,0,1),(997,NULL,'Fouad','Zablith','f.zablith@open.ac.uk',7,'N','N','N','fz99','2009-11-20 20:03:14','2011-04-25 11:48:38',0,NULL,0,0),(998,NULL,'Kristoff','Van Leeuwen','k.vanleeuwen@open.ac.uk',7,'Y','N','N','kl2822','2010-01-11 14:42:03','2011-04-21 16:08:53',0,NULL,0,1),(999,NULL,'Clint','Trofa','c.s.b.trofa@open.ac.uk',7,'Y','N','N','csbt2','2010-01-11 14:42:23','2011-04-21 14:32:18',0,NULL,0,1),(1000,NULL,'James','Heywood','j.heywood@open.ac.uk',7,'N','N','N','jh23876','2010-02-01 16:21:28','2010-05-13 13:11:17',0,NULL,0,1),(1001,NULL,'Guy','Carberry','g.d.carberry@open.ac.uk',7,'N','N','N','gdc53','2010-02-08 14:52:21','2011-05-03 10:41:08',0,NULL,0,1),(1002,NULL,'Ray','Corrigan','r.corrigan@open.ac.uk',7,'N','N','N','rc33','2010-02-24 14:56:10','2011-04-14 13:39:28',0,NULL,0,1),(1003,NULL,'Alan','Davidson','a.w.davidson@open.ac.uk',7,'N','N','N','awd7','2010-02-24 15:01:21','2011-03-13 08:45:39',0,NULL,0,1),(1004,NULL,'Lucy','Taylor','l.p.m.taylor@open.ac.uk',7,'N','N','N','lpmt3','2010-03-02 18:35:09','2011-04-21 07:57:41',0,NULL,0,1),(1005,NULL,'Jackie','Fry','j.fry@open.ac.uk',7,'N','N','N','jf626','2010-03-08 13:44:15','2011-04-28 13:12:47',0,NULL,0,1),(1006,NULL,'Pauline','Adams','p.a.adams@open.ac.uk',7,'N','N','N','paa2','2010-03-11 15:45:16','2011-04-13 13:19:43',0,NULL,0,0),(1007,NULL,'Laura','Dewis','l.dewis@open.ac.uk',7,'N','N','N','ld3623','2010-03-24 10:04:05','2011-04-28 12:46:48',0,NULL,0,1),(1008,NULL,'Simon','Budgen','s.budgen@open.ac.uk',7,'N','N','N','sb26296','2010-03-24 10:12:11','2011-03-28 16:18:47',0,NULL,0,1),(1009,NULL,'Jane','Whild','j.whild@open.ac.uk',7,'N','N','N','jdw4','2010-03-31 09:26:44','2011-04-05 11:36:14',0,NULL,0,1),(1010,NULL,'David','Pilgrim','d.pilgrim@open.ac.uk',7,'N','N','N','dp926','2010-03-31 14:25:56','2011-04-13 14:01:39',0,NULL,0,1),(1011,NULL,'Greg','Black','g.p.black@open.ac.uk',7,'N','N','N','gpb7','2010-03-31 16:16:32','2011-04-28 16:35:31',0,NULL,0,1),(1012,NULL,'Nicky','Waters','n.l.waters@open.ac.uk',7,'N','N','N','nlk2','2010-04-14 14:27:58','2011-04-26 13:48:45',0,NULL,0,1),(1013,NULL,'Mark','Wade','m.c.wade@open.ac.uk',7,'N','N','N','mcw259','2010-04-16 11:41:16','2011-04-14 12:06:31',0,NULL,0,1),(1014,NULL,'Mark','Woodroffe','m.r.woodroffe@open.ac.uk',7,'N','N','N','mrw6','2010-04-16 12:05:12','2011-04-13 15:22:48',0,NULL,0,1),(1015,NULL,'Richard','Cooper','r.j.cooper@open.ac.uk',7,'N','N','N','rjc568','2010-04-28 08:11:10','2011-04-21 11:55:02',0,NULL,0,1),(1016,NULL,'Mark','Stride','m.stride@open.ac.uk',7,'N','N','N','ms3978','2010-05-07 08:54:41','2010-06-29 11:37:42',0,NULL,0,1),(1017,NULL,'Brian','Richardson','b.j.richardson@open.ac.uk',7,'N','N','N','bjr25','2010-05-11 10:13:04','2011-04-13 13:11:49',0,NULL,0,1),(1018,NULL,'David','Lambert','d.j.lambert@open.ac.uk',7,'N','N','N','djl432','2010-05-20 17:09:48','2010-10-26 12:15:05',0,NULL,0,1),(1019,NULL,'Sarah','Stratton','s.j.stratton@open.ac.uk',7,'N','N','N','sjs799','2010-05-26 11:05:35','2011-04-13 14:03:43',0,NULL,0,1),(1020,NULL,'Paul','Conolly','p.conolly@ipproducts.co.uk',7,'N','N','N','pc4757','2010-06-08 17:22:59','0000-00-00 00:00:00',0,NULL,0,1),(1021,NULL,'Richard','Nurse','r.nurse@open.ac.uk',7,'N','N','N','rn2448','2010-06-29 11:44:12','2011-04-18 12:26:03',0,NULL,0,1),(1022,NULL,'Sally','Fallon','s.c.fallon@open.ac.uk',7,'N','N','N','scf28','2010-07-07 16:28:59','2011-03-23 10:40:08',0,NULL,0,1),(1023,NULL,'Paul','Harris','p.g.harris@open.ac.uk',7,'N','N','N','pgh69','2010-07-12 14:40:32','2011-04-13 13:22:25',0,NULL,0,1),(1024,NULL,'Andre','Vock','a.vock@open.ac.uk',7,'N','N','N','av2532','2010-07-16 10:35:06','2011-05-03 09:59:16',0,NULL,0,1),(1025,NULL,'Alan','Marlow','a.j.marlow@open.ac.uk',7,'N','N','N','am9272','2010-07-23 14:44:12','2011-04-05 15:29:14',0,NULL,0,1),(1026,NULL,'Karen','Cropper','k.r.cropper@open.ac.uk',7,'N','N','N','krc67','2010-07-23 14:52:33','2011-01-27 12:04:50',0,NULL,0,1),(1027,NULL,'Hannah','Beaman','h.r.beaman@open.ac.uk',7,'N','N','N','hrb73','2010-07-29 13:48:44','2011-04-06 15:19:55',0,NULL,0,1),(1028,NULL,'Peter','Devine','p.m.devine@open.ac.uk',7,'N','N','N','pmd269','2010-08-05 17:13:09','2011-04-12 10:24:31',0,NULL,0,1),(1029,NULL,'Steven','Price','s.d.price@open.ac.uk',7,'N','N','N','sdp84','2010-08-06 11:50:43','2011-04-26 11:18:42',0,NULL,0,1),(1030,NULL,'Mark','Williams','',7,'N','N','N','mw7827','2010-08-10 06:50:14','2011-04-11 15:34:02',0,NULL,0,1),(1031,NULL,'Janet','Sumner','j.sumner@open.ac.uk',7,'N','N','N','js3876','2010-08-17 12:30:26','2011-04-13 09:05:34',0,NULL,0,1),(1032,NULL,'David','Currie','',7,'N','N','N','dbc49','2010-08-18 15:19:26','2010-10-19 17:14:28',0,NULL,0,1),(1033,NULL,'Kathryn','Skelton','k.skelton@open.ac.uk',7,'N','N','N','ks6533','2010-08-20 06:50:33','2011-04-14 10:33:02',0,NULL,0,1),(1034,NULL,'Helen','Odams','h.c.odams@open.ac.uk',7,'N','N','N','hco8','2010-08-26 06:57:49','2011-04-18 07:19:25',0,NULL,0,1),(1035,NULL,'Wes','Davis','w.davis@open.ac.uk',7,'N','N','N','wd2','2010-09-01 09:16:44','2011-04-14 09:13:22',0,NULL,0,1),(1048,NULL,'Luke','Beaman','l.j.beaman@open.ac.uk',7,'N','N','N','ljb527','2010-10-22 17:47:21','2011-04-13 13:17:45',0,NULL,0,1),(1036,NULL,'Em','Howe','e.howe@open.ac.uk',7,'N','N','N','eh3797','2010-09-01 16:55:20','2010-12-02 16:06:31',0,NULL,0,1),(1037,NULL,'Karen','Leggett','k.j.leggett@open.ac.uk',7,'N','N','N','kjc23','2010-09-03 04:50:45','2011-03-02 16:36:36',0,NULL,0,1),(1038,NULL,'Emma','Birch','e.c.birch@open.ac.uk',7,'N','N','N','ecb222','2010-09-06 04:38:34','2011-04-13 14:50:56',0,NULL,0,1),(1039,NULL,'Nicky','Perry','n.j.perry@open.ac.uk',7,'N','N','N','njp22','2010-09-09 08:55:04','2011-02-07 13:03:01',0,NULL,0,1),(1040,NULL,'Carol','Gillespie','c.a.gillespie@open.ac.uk',7,'N','N','N','cag5','2010-09-22 11:53:13','2011-02-09 09:25:43',0,NULL,0,1),(1041,NULL,'Trish','Cashen','t.cashen@open.ac.uk',7,'N','N','N','pfc24','2010-09-23 14:05:57','2011-04-13 13:22:53',0,NULL,0,1),(1042,NULL,'Ellen','Cocking','e.cocking@open.ac.uk',7,'N','N','N','ej365','2010-09-24 15:42:30','2011-02-08 13:34:12',0,NULL,0,1),(1043,NULL,'Cathy','Jones','c.a.jones@open.ac.uk',7,'Y','N','N','caj362','2010-10-08 15:42:21','2011-04-14 17:33:24',0,NULL,0,1),(1044,NULL,'Elizabeth','Ellis','e.ellis@open.ac.uk',7,'Y','N','N','ee944','2010-10-08 15:42:32','2010-10-28 10:40:18',0,NULL,0,1),(1045,NULL,'Lisa','Hewer','l.hewer@open.ac.uk',7,'N','N','N','lh5949','2010-10-19 10:37:44','2011-04-26 14:16:01',0,NULL,0,1),(1046,NULL,'Victoria','Stead','v.stead@open.ac.uk',7,'N','N','N','vs3833','2010-10-19 10:30:00','2011-04-13 16:25:37',0,NULL,0,1),(1047,NULL,'Claudia','Rosani-Allen','c.rosani-allen@open.ac.uk',7,'N','N','N','cra53','2010-11-09 15:26:31','2011-04-28 11:13:15',0,NULL,0,1),(1049,NULL,'Lesley','Green','l.green@open.ac.uk',7,'N','N','N','lg5','2010-10-26 04:30:56','2011-04-26 15:26:45',0,NULL,0,1),(1050,NULL,'Caroline','Jeffreys','c.a.jeffreys@open.ac.uk',7,'N','N','N','cag4','2010-10-26 04:31:55','2011-04-13 13:21:04',0,NULL,0,1),(1051,NULL,'Nick','Freear','n.d.freear@open.ac.uk',7,'N','N','N','ndf42','2010-10-30 03:28:06','2011-04-27 17:10:15',0,NULL,0,1),(1052,NULL,'Crispin','Boyd','c.boyd@open.ac.uk',7,'N','N','N','cb9294','2010-11-02 09:31:26','2011-04-13 14:59:19',0,NULL,0,1),(1053,NULL,'Stuart','Overton-Grace','s.overton-grace@open.ac.uk',7,'N','N','N','sg6753','2010-11-09 14:01:28','2011-04-13 13:46:22',0,NULL,0,1),(1056,NULL,'Katrina','Chambers','k.l.chambers@open.ac.uk',7,'N','N','N','klw274','2010-11-11 10:57:19','2011-04-13 13:23:48',0,NULL,0,1),(1057,NULL,'Michelle','Gallacher','m.a.gallacher@open.ac.uk',7,'N','N','N','mag37','2010-11-16 15:44:33','2010-12-20 14:03:41',0,NULL,0,1),(1058,NULL,'Pat','Dixon','p.s.dixon@open.ac.uk',7,'N','N','N','psd62','2010-11-17 11:03:39','2011-03-22 09:27:44',0,NULL,0,1),(1059,NULL,'Yvonne','Shepherd','y.shepherd@open.ac.uk',7,'N','N','N','ys8','2010-11-17 11:04:14','2011-04-13 13:21:01',0,NULL,0,1),(1060,NULL,'Elizabeth','Vidler','e.vidler@open.ac.uk',7,'N','N','N','ev97','2010-11-24 10:35:46','2011-04-13 13:55:09',0,NULL,0,1),(1061,NULL,'Namita','Singh','n.singh@open.ac.uk',7,'N','N','N','ns5627','2010-12-04 20:23:20','2010-12-06 10:46:31',0,NULL,0,1),(1062,NULL,'Ryan','Cox','r.cox@open.ac.uk',7,'N','N','N','rc4294','2010-12-06 09:38:48','2011-01-24 09:02:54',0,NULL,0,1),(1063,NULL,'Robert','Page','r.j.page@open.ac.uk',7,'Y','N','N','rjp298','2010-12-15 04:40:46','2011-04-21 10:26:08',0,NULL,0,1),(1064,NULL,'Luke','Stephenson','l.stephenson@open.ac.uk',7,'N','N','N','ls5279','2011-01-12 13:09:25','2011-01-14 14:37:20',0,NULL,0,1),(1065,NULL,'Stephanie','Webster','s.webster@open.ac.uk',7,'N','N','N','sw8226','2011-01-12 13:09:50','2011-04-15 15:26:34',0,NULL,0,1),(1066,NULL,'Rachel','Garnham','r.garnham@open.ac.uk',7,'N','N','N','rg3968','2011-01-13 13:57:25','2011-04-28 14:00:02',0,NULL,0,1),(1067,NULL,'Pauline','Leung','p.leung@open.ac.uk',7,'N','N','N','pl662','2011-01-20 10:03:50','2011-04-14 11:00:10',0,NULL,0,1),(1068,NULL,'Helen','Cooke','h.j.cooke@open.ac.uk',7,'N','N','N','hjc259','2011-01-25 16:52:19','2011-04-13 16:10:29',0,NULL,0,1),(1069,NULL,'Paul','Raby','p.g.raby@open.ac.uk',7,'N','N','N','pgr74','2011-01-27 13:02:15','2011-04-14 14:36:56',0,NULL,0,1),(1070,NULL,'Jane','Hardwick','j.s.hardwick@open.ac.uk',7,'N','N','N','jsh355','2011-01-27 13:03:40','2011-01-27 15:08:06',0,NULL,0,1),(1071,NULL,'Carey','Stephens','c.a.stephens@open.ac.uk',7,'N','N','N','cas569','2011-01-27 13:04:22','2011-04-14 08:10:17',0,NULL,0,1),(1072,NULL,'Hannelore','Green','h.green@open.ac.uk',7,'N','N','N','hg23','2011-01-27 13:05:02','2011-04-13 17:03:54',0,NULL,0,1),(1073,NULL,'Malcolm','Beet','m.beet@open.ac.uk',7,'N','N','N','mb3858','2011-01-27 13:06:22','2011-04-14 09:49:02',0,NULL,0,1),(1074,NULL,'Jenny','Lynden','j.n.lynden@open.ac.uk',7,'N','N','N','jml365','2011-01-27 13:07:38','0000-00-00 00:00:00',0,NULL,0,1),(1075,NULL,'Lucy','Rumney','l.rumney@open.ac.uk',7,'N','N','N','lr362','2011-01-27 13:08:25','2011-05-03 10:42:21',0,NULL,0,1),(1076,NULL,'James','Roy','j.w.roy@open.ac.uk',7,'N','N','N','jwr79','2011-01-27 13:08:58','2011-02-04 19:27:29',0,NULL,0,1),(1077,NULL,'Phillis','Jones','p.jones@open.ac.uk',7,'N','N','N','pj32','2011-01-27 13:10:19','2011-01-28 16:07:53',0,NULL,0,1),(1078,NULL,'Janice','Holmes','j.e.holmes@open.ac.uk',7,'N','N','N','jeh35','2011-01-27 13:11:00','2011-04-14 20:50:42',0,NULL,0,1),(1079,NULL,'Sue','Truby','s.m.truby@open.ac.uk',7,'N','N','N','smt22','2011-01-27 13:11:40','2011-04-14 08:27:08',0,NULL,0,1),(1080,NULL,'Victoria','Nicholas','v.m.t.nicholas@open.ac.uk',7,'N','N','N','vms9','2011-01-29 18:13:12','2011-04-14 10:26:51',0,NULL,0,1),(1081,NULL,'Bill','Alder','w.g.alder@open.ac.uk',7,'N','N','N','wga7','2011-01-31 10:43:49','0000-00-00 00:00:00',0,NULL,0,1),(1082,NULL,'Alex','Twiselton','at5873@openmail.open.ac.uk',7,'N','N','N','at5873','2011-02-02 02:29:28','0000-00-00 00:00:00',0,NULL,0,1),(1083,NULL,'Nadine','Afflick','na3553@openmail.open.ac.uk',7,'N','N','N','na3553','2011-02-02 02:30:13','2011-03-15 15:53:20',0,NULL,0,1),(1084,NULL,'Clare','Warren','c.warren@open.ac.uk',7,'N','N','N','cw6522','2011-02-03 09:40:58','2011-04-13 13:26:36',0,NULL,0,1),(1085,NULL,'Emma','Lawrence','e.lawrence@open.ac.uk',7,'N','N','N','el2854','2011-02-22 14:27:14','2011-04-14 09:44:52',0,NULL,0,1),(1086,NULL,'Lee','Taylor','',7,'Y','N','N','ljt282','2011-02-23 05:37:54','0000-00-00 00:00:00',0,NULL,0,1),(1087,NULL,'Rosalind','Crone','r.h.crone@open.ac.uk',7,'N','N','N','rhc78','2011-02-23 11:10:24','0000-00-00 00:00:00',0,NULL,0,1),(1088,NULL,'Wendy','Woolery','w.woolery@open.ac.uk',7,'N','N','N','wkw22','2011-02-25 03:19:05','2011-04-11 15:49:22',0,NULL,0,1),(1089,NULL,'carolyn','richardson','c.p.richardson@open.ac.uk',7,'N','N','N','cpr3','2011-02-28 11:06:56','0000-00-00 00:00:00',0,NULL,0,1),(1090,NULL,'Stephen','Turvey','@open.ac.uk',7,'N','N','N','st4792','2011-02-28 12:14:37','2011-04-01 16:22:22',0,NULL,0,1),(1091,NULL,'Jane','Bromley','j.t.bromley@open.ac.uk',7,'N','N','N','jtb24','2011-03-07 02:35:47','2011-04-13 13:07:39',0,NULL,0,1),(1092,NULL,'Lucy','Metcalfe','l.metcalfe@open.ac.uk',7,'N','N','N','lm86','2011-03-09 16:39:28','2011-04-19 13:24:00',0,NULL,0,1),(1093,NULL,'Lisa','Pilgram','l.m.pilgram@open.ac.uk',7,'N','N','N','lmp363','2011-03-10 05:39:54','2011-04-04 14:35:16',0,NULL,0,1),(1094,NULL,'Anne','Paynter','a.m.paynter@open.ac.uk',7,'N','N','N','amp52','2011-03-10 05:40:31','0000-00-00 00:00:00',0,NULL,0,1),(1095,NULL,'Alba','Madriz','a.madriz@open.ac.uk',7,'N','N','N','am25763','2011-03-11 10:06:23','2011-03-30 16:50:20',0,NULL,0,1),(1096,NULL,'Sas','Amoah','s.m.amoah@open.ac.uk',7,'Y','N','N','sma266','2011-03-15 04:15:53','2011-04-28 11:03:03',0,NULL,0,1),(1097,NULL,'Andrew','Rix','',7,'N','N','N','akr3','2011-03-17 22:37:20','2011-04-26 14:06:04',0,NULL,0,1),(1098,NULL,'Sharon','Dawes','s.r.dawes@open.ac.uk',7,'N','N','N','srd78','2011-03-18 14:41:56','2011-04-05 23:24:28',0,NULL,0,1),(1099,NULL,'Jessica','Hughes','jessica.hughes@open.ac.uk',7,'N','N','N','jh23373','2011-03-21 12:02:05','2011-04-20 12:43:14',0,NULL,0,1),(1100,NULL,'Jamie','Daniels','j.d.daniels@open.ac.uk',9,'Y','Y','Y','jdd7','2011-04-18 13:43:41','2011-05-03 10:35:45',0,NULL,1,1),(1101,NULL,'John','Rose-Adams','j.rose-adams@open.ac.uk',7,'N','N','N','ja5332','2011-03-31 10:51:19','2011-04-27 11:55:15',0,NULL,0,1),(1102,NULL,'Sue','Mann','',7,'Y','N','N','sm26739','2011-04-15 17:49:46','2011-05-02 18:37:45',0,NULL,0,1),(1103,NULL,'Robert','Johnstone','r.t.johnstone@open.ac.uk',7,'N','N','N','rtj4','2011-04-19 02:00:19','2011-04-19 08:09:16',0,NULL,0,1),(1104,NULL,'Paola','Macioti','p.g.macioti@open.ac.uk',7,'N','N','N','pgm262','2011-04-18 10:51:59','2011-04-19 14:24:24',0,NULL,0,1),(1105,NULL,'Claudia','Aradau','c.e.aradau@open.ac.uk',7,'N','N','N','cea92','2011-04-18 10:52:35','2011-04-20 17:31:23',0,NULL,0,1),(1106,NULL,'Jef','Huysmans','j.p.a.huysmans@open.ac.uk',7,'N','N','N','jpah2','2011-04-18 10:53:54','0000-00-00 00:00:00',0,NULL,0,1),(1107,NULL,'Carole','Moyle','c.e.moyle@open.ac.uk',7,'N','N','N','cem33','2011-04-18 10:54:24','0000-00-00 00:00:00',0,NULL,0,1),(1108,NULL,'Carol','Johns-Mackenzie','c.l.johns-mackenzie@open.ac.uk',7,'N','N','N','cljm3','2011-04-19 11:57:49','2011-05-03 11:09:07',0,NULL,0,1),(1109,NULL,'Chris','Nelson','c.nelson@open.ac.uk',7,'N','N','N','cn2383','2011-04-26 22:47:20','2011-04-27 11:52:07',0,NULL,0,1),(1110,'Mr','Charles','Jackson','c.jackson@open.ac.uk',1,'Y','Y','Y','cj3998','2011-05-10 11:44:04','2011-05-10 11:44:04',1,NULL,1,1),(1113,NULL,'Joe','Bloggs','j.bloggs@open.ac.uk',0,'N','N','N','cxxxpv2','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2011-05-10 14:40:00',0,1);
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

-- Dump completed on 2011-06-21 15:20:59
