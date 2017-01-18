-- MySQL dump 10.13  Distrib 5.7.11, for Win32 (AMD64)
--
-- Host: localhost    Database: crowdfunding
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_esperanto_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Technologie'),(2,'Éducation'),(3,'Gastronomie'),(4,'Musique'),(5,'Jeux'),(6,'Communauté'),(7,'Innovation'),(8,'Mode'),(9,'Design'),(10,'Sport'),(11,'Cinéma'),(12,'Littérature'),(13,'Évènementiel');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Afghanistan'),(2,'Albanie'),(3,'Antarctique'),(4,'Algérie'),(5,'Samoa Américaines'),(6,'Andorre'),(7,'Angola'),(8,'Antigua-et-Barbuda'),(9,'Azerbaïdjan'),(10,'Argentine'),(11,'Australie'),(12,'Autriche'),(13,'Bahamas'),(14,'Bahreïn'),(15,'Bangladesh'),(16,'Arménie'),(17,'Barbade'),(18,'Belgique'),(19,'Bermudes'),(20,'Bhoutan'),(21,'Bolivie'),(22,'Bosnie-Herzégovine'),(23,'Botswana'),(24,'Île Bouvet'),(25,'Brésil'),(26,'Belize'),(27,'Territoire Britannique de l\'Océan Indien'),(28,'Îles Salomon'),(29,'Îles Vierges Britanniques'),(30,'Brunéi Darussalam'),(31,'Bulgarie'),(32,'Myanmar'),(33,'Burundi'),(34,'Bélarus'),(35,'Cambodge'),(36,'Cameroun'),(37,'Canada'),(38,'Cap-vert'),(39,'Îles Caïmanes'),(40,'République Centrafricaine'),(41,'Sri Lanka'),(42,'Tchad'),(43,'Chili'),(44,'Chine'),(45,'Taïwan'),(46,'Île Christmas'),(47,'Îles Cocos (Keeling)'),(48,'Colombie'),(49,'Comores'),(50,'Mayotte'),(51,'République du Congo'),(52,'République Démocratique du Congo'),(53,'Îles Cook'),(54,'Costa Rica'),(55,'Croatie'),(56,'Cuba'),(57,'Chypre'),(58,'République Tchèque'),(59,'Bénin'),(60,'Danemark'),(61,'Dominique'),(62,'République Dominicaine'),(63,'Équateur'),(64,'El Salvador'),(65,'Guinée Équatoriale'),(66,'Éthiopie'),(67,'Érythrée'),(68,'Estonie'),(69,'Îles Féroé'),(70,'Îles (malvinas) Falkland'),(71,'Géorgie du Sud et les Îles Sandwich du Sud'),(72,'Fidji'),(73,'Finlande'),(74,'Îles Åland'),(75,'France'),(76,'Guyane Française'),(77,'Polynésie Française'),(78,'Terres Australes Françaises'),(79,'Djibouti'),(80,'Gabon'),(81,'Géorgie'),(82,'Gambie'),(83,'Territoire Palestinien Occupé'),(84,'Allemagne'),(85,'Ghana'),(86,'Gibraltar'),(87,'Kiribati'),(88,'Grèce'),(89,'Groenland'),(90,'Grenade'),(91,'Guadeloupe'),(92,'Guam'),(93,'Guatemala'),(94,'Guinée'),(95,'Guyana'),(96,'Haïti'),(97,'Îles Heard et Mcdonald'),(98,'Saint-Siège (état de la Cité du Vatican)'),(99,'Honduras'),(100,'Hong-Kong'),(101,'Hongrie'),(102,'Islande'),(103,'Inde'),(104,'Indonésie'),(105,'République Islamique d\'Iran'),(106,'Iraq'),(107,'Irlande'),(108,'Israël'),(109,'Italie'),(110,'Côte d\'Ivoire'),(111,'Jamaïque'),(112,'Japon'),(113,'Kazakhstan'),(114,'Jordanie'),(115,'Kenya'),(116,'République Populaire Démocratique de Corée'),(117,'République de Corée'),(118,'Koweït'),(119,'Kirghizistan'),(120,'République Démocratique Populaire Lao'),(121,'Liban'),(122,'Lesotho'),(123,'Lettonie'),(124,'Libéria'),(125,'Jamahiriya Arabe Libyenne'),(126,'Liechtenstein'),(127,'Lituanie'),(128,'Luxembourg'),(129,'Macao'),(130,'Madagascar'),(131,'Malawi'),(132,'Malaisie'),(133,'Maldives'),(134,'Mali'),(135,'Malte'),(136,'Martinique'),(137,'Mauritanie'),(138,'Maurice'),(139,'Mexique'),(140,'Monaco'),(141,'Mongolie'),(142,'République de Moldova'),(143,'Montserrat'),(144,'Maroc'),(145,'Mozambique'),(146,'Oman'),(147,'Namibie'),(148,'Nauru'),(149,'Népal'),(150,'Pays-Bas'),(151,'Antilles Néerlandaises'),(152,'Aruba'),(153,'Nouvelle-Calédonie'),(154,'Vanuatu'),(155,'Nouvelle-Zélande'),(156,'Nicaragua'),(157,'Niger'),(158,'Nigéria'),(159,'Niué'),(160,'Île Norfolk'),(161,'Norvège'),(162,'Îles Mariannes du Nord'),(163,'Îles Mineures Éloignées des États-Unis'),(164,'États Fédérés de Micronésie'),(165,'Îles Marshall'),(166,'Palaos'),(167,'Pakistan'),(168,'Panama'),(169,'Papouasie-Nouvelle-Guinée'),(170,'Paraguay'),(171,'Pérou'),(172,'Philippines'),(173,'Pitcairn'),(174,'Pologne'),(175,'Portugal'),(176,'Guinée-Bissau'),(177,'Timor-Leste'),(178,'Porto Rico'),(179,'Qatar'),(180,'Réunion'),(181,'Roumanie'),(182,'Fédération de Russie'),(183,'Rwanda'),(184,'Sainte-Hélène'),(185,'Saint-Kitts-et-Nevis'),(186,'Anguilla'),(187,'Sainte-Lucie'),(188,'Saint-Pierre-et-Miquelon'),(189,'Saint-Vincent-et-les Grenadines'),(190,'Saint-Marin'),(191,'Sao Tomé-et-Principe'),(192,'Arabie Saoudite'),(193,'Sénégal'),(194,'Seychelles'),(195,'Sierra Leone'),(196,'Singapour'),(197,'Slovaquie'),(198,'Viet Nam'),(199,'Slovénie'),(200,'Somalie'),(201,'Afrique du Sud'),(202,'Zimbabwe'),(203,'Espagne'),(204,'Sahara Occidental'),(205,'Soudan'),(206,'Suriname'),(207,'Svalbard etÎle Jan Mayen'),(208,'Swaziland'),(209,'Suède'),(210,'Suisse'),(211,'République Arabe Syrienne'),(212,'Tadjikistan'),(213,'Thaïlande'),(214,'Togo'),(215,'Tokelau'),(216,'Tonga'),(217,'Trinité-et-Tobago'),(218,'Émirats Arabes Unis'),(219,'Tunisie'),(220,'Turquie'),(221,'Turkménistan'),(222,'Îles Turks et Caïques'),(223,'Tuvalu'),(224,'Ouganda'),(225,'Ukraine'),(226,'L\'ex-République Yougoslave de Macédoine'),(227,'Égypte'),(228,'Royaume-Uni'),(229,'Île de Man'),(230,'République-Unie de Tanzanie'),(231,'États-Unis'),(232,'Îles Vierges des États-Unis'),(233,'Burkina Faso'),(234,'Uruguay'),(235,'Ouzbékistan'),(236,'Venezuela'),(237,'Wallis et Futuna'),(238,'Samoa'),(239,'Yémen'),(240,'Serbie-et-Monténégro'),(241,'Zambie');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favouritecategory`
--

DROP TABLE IF EXISTS `favouritecategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favouritecategory` (
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`category_id`),
  KEY `favouritecategory_category_idx` (`category_id`),
  CONSTRAINT `favouritecategory_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `favouritecategory_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favouritecategory`
--

LOCK TABLES `favouritecategory` WRITE;
/*!40000 ALTER TABLE `favouritecategory` DISABLE KEYS */;
INSERT INTO `favouritecategory` VALUES (1,1,2),(1,4,1),(1,5,3),(2,1,3),(2,6,2),(2,12,1),(3,2,1),(3,5,3),(3,8,2),(4,5,3),(4,10,2),(4,12,1),(5,7,1),(5,8,3),(5,9,2),(6,3,3),(6,4,1),(6,12,2),(7,3,1),(7,10,2),(7,11,3),(8,1,2),(8,7,3),(8,9,1),(9,1,3),(9,4,2),(9,5,1),(10,6,2),(10,8,3),(10,11,1),(11,6,3),(11,7,1),(11,11,2),(12,2,3),(12,7,2),(12,8,1),(13,6,3),(13,8,2),(13,10,1),(14,2,1),(14,3,3),(14,9,2),(15,5,1),(15,12,2),(15,13,3),(16,1,1),(16,2,2),(16,9,3),(17,3,2),(17,4,1),(17,9,3),(18,5,3),(18,6,2),(18,8,1),(19,5,3),(19,6,2),(19,7,1),(20,2,3),(20,3,2),(20,11,1);
/*!40000 ALTER TABLE `favouritecategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift`
--

DROP TABLE IF EXISTS `gift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) CHARACTER SET utf8 NOT NULL,
  `minamount` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_esperanto_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gift_project_idx` (`project_id`),
  CONSTRAINT `gift_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift`
--

LOCK TABLES `gift` WRITE;
/*!40000 ALTER TABLE `gift` DISABLE KEYS */;
INSERT INTO `gift` VALUES (1,'Donec',67,'Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis',1),(2,'imperdiet ornare. In',37,'erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam',1),(3,'Donec elementum,',5,'Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim',2),(4,'a, dui.',12,'mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et',2),(5,'mi enim,',73,'eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed',3),(6,'Cras vehicula',39,'ante. Maecenas mi felis, adipiscing',3),(7,'lectus',82,'varius ultrices, mauris ipsum porta elit,',4),(8,'faucibus. Morbi',49,'eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a,',4),(9,'Fusce',47,'fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae',5),(10,'nec',11,'fringilla mi lacinia mattis. Integer eu',5),(11,'justo',25,'vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem ut',6),(12,'dignissim',88,'cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum',6),(13,'est',29,'a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate',7),(14,'velit. Pellentesque',43,'accumsan neque et nunc. Quisque ornare',7),(15,'sed dolor. Fusce',26,'metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec',8),(16,'facilisis facilisis,',70,'Curabitur vel lectus. Cum sociis natoque penatibus',8),(17,'vulputate,',78,'ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus',9),(18,'scelerisque, lorem ipsum',63,'quis diam. Pellentesque habitant morbi tristique senectus et netus',9),(19,'adipiscing ligula.',100,'pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus.',10),(20,'Aliquam tincidunt, nunc',17,'egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor',10),(21,'lacus. Etiam',11,'ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas.',11),(22,'nisi magna',34,'hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et,',11),(23,'penatibus et magnis',22,'scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia.',12),(24,'mus. Proin',80,'fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor',12),(25,'dapibus id,',84,'egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id',13),(26,'sed pede',13,'nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et',13),(27,'nulla. Integer',48,'Pellentesque tincidunt tempus risus. Donec egestas. Duis ac',14),(28,'felis',16,'augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend',14),(29,'Quisque ornare tortor',85,'Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet,',15),(30,'quis turpis',37,'vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus',15),(31,'mauris sit amet',21,'Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',16),(32,'eu nibh',28,'Etiam gravida molestie arcu. Sed eu nibh',16),(33,'sit amet',19,'parturient montes, nascetur ridiculus mus. Aenean eget magna.',17),(34,'sapien, cursus',89,'vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante.',17),(35,'faucibus ut, nulla.',77,'Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus.',18),(36,'sociis natoque penatibus',2,'quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent',18),(37,'luctus, ipsum',75,'nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit',19),(38,'sit',92,'neque sed dictum eleifend, nunc risus varius orci, in',19),(39,'nascetur ridiculus mus.',27,'pede, malesuada vel, venenatis vel, faucibus',20),(40,'Aenean massa.',97,'diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per',20),(41,'contrepartie 1',10,'contrepartie 1 description',21);
/*!40000 ALTER TABLE `gift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentmethod`
--

DROP TABLE IF EXISTS `paymentmethod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paymentmethod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_esperanto_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentmethod`
--

LOCK TABLES `paymentmethod` WRITE;
/*!40000 ALTER TABLE `paymentmethod` DISABLE KEYS */;
INSERT INTO `paymentmethod` VALUES (1,'CB'),(2,'Paypal'),(3,'Bitcoin');
/*!40000 ALTER TABLE `paymentmethod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `picture`
--

DROP TABLE IF EXISTS `picture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_esperanto_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `picture_project_idx` (`project_id`),
  CONSTRAINT `picture_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picture`
--

LOCK TABLES `picture` WRITE;
/*!40000 ALTER TABLE `picture` DISABLE KEYS */;
INSERT INTO `picture` VALUES (1,'img/placeholder_main.jpg',15),(2,'img/placeholder_main.jpg',7),(3,'img/placeholder_main.jpg',5),(4,'img/placeholder_main.jpg',20),(5,'img/placeholder_main.jpg',17),(6,'img/placeholder_main.jpg',16),(7,'img/placeholder_main.jpg',4),(8,'img/placeholder_main.jpg',16),(9,'img/placeholder_main.jpg',4),(10,'img/placeholder_main.jpg',20),(11,'img/placeholder_main.jpg',6),(12,'img/placeholder_main.jpg',19),(13,'img/placeholder_main.jpg',14),(14,'img/placeholder_main.jpg',17),(15,'img/placeholder_main.jpg',7),(16,'img/placeholder_main.jpg',3),(17,'img/placeholder_main.jpg',18),(18,'img/placeholder_main.jpg',20),(19,'img/placeholder_main.jpg',14),(20,'img/placeholder_main.jpg',14),(21,'img/placeholder_main.jpg',11),(22,'img/placeholder_main.jpg',5),(23,'img/placeholder_main.jpg',15),(24,'img/placeholder_main.jpg',9),(25,'img/placeholder_main.jpg',15),(26,'img/placeholder_main.jpg',17),(27,'img/placeholder_main.jpg',1),(28,'img/placeholder_main.jpg',4),(29,'img/placeholder_main.jpg',2),(30,'img/placeholder_main.jpg',14),(31,'img/placeholder_main.jpg',11),(32,'img/placeholder_main.jpg',14),(33,'img/placeholder_main.jpg',12),(34,'img/placeholder_main.jpg',5),(35,'img/placeholder_main.jpg',2);
/*!40000 ALTER TABLE `picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(80) COLLATE utf8_esperanto_ci NOT NULL,
  `subtitle` varchar(90) COLLATE utf8_esperanto_ci NOT NULL,
  `description` varchar(10000) COLLATE utf8_esperanto_ci NOT NULL,
  `mainpicture` varchar(255) COLLATE utf8_esperanto_ci NOT NULL,
  `creationdate` date NOT NULL,
  `deadline` date NOT NULL,
  `goal` int(11) NOT NULL,
  `promotionend` date DEFAULT NULL,
  `transactionsum` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `project_user_idx` (`user_id`),
  CONSTRAINT `project_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,20,'risus. Quisque libero','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-24','2017-05-30',27558,NULL,62),(2,20,'turpis non','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-15','2017-06-05',44727,NULL,1548),(3,16,'mattis semper, dui lectus','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-26','2017-05-31',44021,NULL,11),(4,16,'mi. Duis risus odio,','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-17','2017-05-16',21764,NULL,0),(5,14,'cursus','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-31','2017-06-03',49239,NULL,38),(6,11,'Nunc','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-31','2017-06-03',19864,NULL,96),(7,12,'lorem tristique aliquet. Phasellus','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-04','2017-05-22',11387,NULL,0),(8,15,'arcu vel quam','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-04-30','2017-06-05',13685,NULL,19),(9,15,'nulla at sem','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-04-29','2017-06-07',21924,NULL,88),(10,17,'porttitor eros nec','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-05','2017-05-09',10773,NULL,76),(11,14,'aliquam eros turpis','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-01','2017-05-12',24384,NULL,0),(12,12,'nisl.','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-04-03','2017-05-08',36685,NULL,120),(13,16,'convallis in, cursus et, eros.','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-12','2017-05-03',45162,NULL,29),(14,17,'justo.','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-04-01','2017-05-20',39747,NULL,0),(15,16,'ante dictum cursus. Nunc','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-23','2017-05-08',8279,NULL,0),(16,16,'dolor egestas rhoncus. Proin nisl','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-28','2017-06-02',47705,NULL,82),(17,18,'Donec fringilla.','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-01','2017-06-04',6791,NULL,0),(18,11,'quis, pede.','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-04-30','2017-06-03',7284,NULL,0),(19,18,'risus.','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-09','2017-06-01',16407,NULL,0),(20,17,'lectus. Cum sociis','Lorem ipsum dolor sit amet, consectuere famus doloris.','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','img/placeholder_main.jpg','2017-03-16','2017-05-31',40749,NULL,0),(21,19,'test update project','subtitle','<h1 style=\"text-align: justify;\">Voici la description</h1><h2>sous-titre</h2><blockquote>citation</blockquote><div>Ce projet est <b>super</b> car:</div><ul><li>c\'est le mien</li><li>ok</li><li>et oui</li></ul>','/img/project/21/Samuel-Tel.png','2016-12-07','2017-01-27',5000,'2016-12-29',15),(22,19,'test icons','ok','<p>ok</p>','/img/project/22/kenvad.jpg','2016-12-23','2017-02-24',540,NULL,0);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projectcategory`
--

DROP TABLE IF EXISTS `projectcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projectcategory` (
  `project_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`category_id`),
  KEY `projectcategory_category_idx` (`category_id`),
  CONSTRAINT `projectcategory_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projectcategory_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projectcategory`
--

LOCK TABLES `projectcategory` WRITE;
/*!40000 ALTER TABLE `projectcategory` DISABLE KEYS */;
INSERT INTO `projectcategory` VALUES (6,1),(9,1),(16,1),(19,1),(8,2),(11,2),(13,2),(18,2),(21,2),(22,2),(4,3),(6,3),(2,4),(7,4),(10,4),(14,4),(16,4),(21,4),(3,5),(4,5),(7,5),(15,5),(17,5),(20,5),(2,7),(5,7),(14,7),(12,8),(13,8),(18,8),(20,8),(1,9),(8,9),(10,9),(12,10),(3,11),(11,11),(15,12),(17,12),(1,13),(5,13),(9,13),(19,13);
/*!40000 ALTER TABLE `projectcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projecttag`
--

DROP TABLE IF EXISTS `projecttag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projecttag` (
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`tag_id`),
  KEY `projecttag_tag_idx` (`tag_id`),
  CONSTRAINT `projecttag_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projecttag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projecttag`
--

LOCK TABLES `projecttag` WRITE;
/*!40000 ALTER TABLE `projecttag` DISABLE KEYS */;
INSERT INTO `projecttag` VALUES (2,1),(11,6),(15,9),(2,11),(4,11),(2,15),(13,19),(18,20),(12,21),(13,21),(21,26),(22,27);
/*!40000 ALTER TABLE `projecttag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projectview`
--

DROP TABLE IF EXISTS `projectview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projectview` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`project_id`,`date`),
  KEY `projectview_project_idx` (`project_id`),
  CONSTRAINT `projectview_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projectview_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projectview`
--

LOCK TABLES `projectview` WRITE;
/*!40000 ALTER TABLE `projectview` DISABLE KEYS */;
INSERT INTO `projectview` VALUES (4,1,'2017-04-18 17:50:00'),(5,1,'2017-04-15 16:37:37'),(6,1,'2017-04-29 20:33:51'),(9,1,'2017-04-10 15:31:45'),(9,1,'2017-04-17 23:47:55'),(10,1,'2017-04-19 05:31:44'),(11,1,'2017-05-01 11:22:22'),(12,1,'2017-04-21 00:33:44'),(13,1,'2017-04-20 17:19:15'),(14,1,'2017-04-20 21:53:45'),(15,1,'2017-04-11 11:36:11'),(15,1,'2017-04-13 15:15:32'),(16,1,'2017-04-03 18:47:07'),(17,1,'2017-04-03 05:59:57'),(17,1,'2017-04-08 05:09:07'),(19,1,'2017-04-08 04:49:29'),(1,2,'2017-04-28 07:53:40'),(2,2,'2017-04-06 07:39:06'),(3,2,'2017-04-23 15:35:01'),(4,2,'2017-04-19 06:36:02'),(4,2,'2017-04-28 17:49:37'),(6,2,'2017-04-10 03:47:57'),(6,2,'2017-04-25 22:28:40'),(7,2,'2017-04-17 14:14:48'),(9,2,'2017-04-13 00:44:25'),(20,2,'2017-04-09 18:31:57'),(1,3,'2017-04-03 23:52:18'),(2,3,'2017-04-15 08:39:28'),(3,3,'2017-04-06 03:01:39'),(4,3,'2017-04-27 15:45:59'),(5,3,'2017-04-20 00:08:52'),(8,3,'2017-04-02 07:26:08'),(14,3,'2017-04-13 22:01:09'),(15,3,'2017-04-11 16:10:06'),(17,3,'2017-04-22 08:22:54'),(4,4,'2017-04-18 15:58:15'),(5,4,'2017-04-07 04:15:00'),(6,4,'2017-04-17 05:08:46'),(7,4,'2017-04-03 10:33:45'),(8,4,'2017-04-03 13:44:53'),(12,4,'2017-04-27 15:31:02'),(13,4,'2017-04-09 17:22:34'),(15,4,'2017-04-08 15:43:58'),(15,4,'2017-04-30 03:36:46'),(20,4,'2017-04-05 16:26:15'),(20,4,'2017-04-06 23:16:44'),(5,5,'2017-04-02 21:37:17'),(7,5,'2017-04-07 02:23:56'),(7,5,'2017-04-24 02:45:43'),(8,5,'2017-04-25 12:44:05'),(9,5,'2017-04-14 02:36:05'),(12,5,'2017-04-05 08:34:15'),(12,5,'2017-04-05 17:49:11'),(15,5,'2017-04-05 01:51:20'),(19,5,'2017-04-10 11:13:13'),(19,5,'2017-04-12 22:48:55'),(20,5,'2017-04-14 23:13:57'),(20,5,'2017-04-16 19:48:47'),(1,6,'2017-04-21 21:24:55'),(3,6,'2017-04-24 20:20:04'),(4,6,'2017-04-03 02:48:09'),(5,6,'2017-04-06 00:13:48'),(5,6,'2017-04-14 15:25:56'),(5,6,'2017-04-15 20:20:22'),(6,6,'2017-04-09 01:58:47'),(6,6,'2017-04-12 12:05:46'),(7,6,'2017-04-02 03:33:35'),(7,6,'2017-04-11 18:24:59'),(8,6,'2017-04-17 22:56:35'),(10,6,'2017-04-06 10:30:34'),(13,6,'2017-04-07 20:34:00'),(13,6,'2017-04-09 04:44:40'),(18,6,'2017-04-26 08:45:21'),(19,6,'2017-04-21 00:16:44'),(3,7,'2017-04-15 00:37:53'),(5,7,'2017-04-07 14:25:56'),(5,7,'2017-04-30 02:30:20'),(7,7,'2017-04-24 20:57:38'),(12,7,'2017-04-23 06:29:33'),(13,7,'2017-04-19 01:00:46'),(15,7,'2017-04-20 20:11:23'),(15,7,'2017-04-26 03:18:57'),(20,7,'2017-04-16 14:26:41'),(2,8,'2017-04-19 01:25:57'),(3,8,'2017-04-07 10:49:52'),(16,8,'2017-04-09 20:12:22'),(16,8,'2017-04-11 18:25:18'),(17,8,'2017-04-12 09:29:33'),(18,8,'2017-04-28 15:02:33'),(20,8,'2017-04-13 04:23:00'),(1,9,'2017-04-19 11:04:16'),(5,9,'2017-04-15 20:53:30'),(5,9,'2017-04-28 11:47:10'),(13,9,'2017-04-05 10:27:18'),(15,9,'2017-04-23 09:47:14'),(2,10,'2017-04-08 15:28:33'),(3,10,'2017-04-22 13:30:06'),(7,10,'2017-04-08 15:18:52'),(10,10,'2017-04-14 10:01:56'),(10,10,'2017-04-15 20:35:36'),(10,10,'2017-04-29 12:44:06'),(12,10,'2017-04-04 18:35:02'),(12,10,'2017-04-25 06:06:26'),(17,10,'2017-04-02 19:29:10'),(18,10,'2017-04-20 03:54:13'),(20,10,'2017-04-01 22:34:38'),(2,11,'2017-04-20 09:54:38'),(2,11,'2017-04-20 16:59:03'),(4,11,'2017-04-02 11:31:20'),(4,11,'2017-04-16 03:06:36'),(4,11,'2017-04-21 10:33:21'),(5,11,'2017-04-02 01:45:03'),(9,11,'2017-04-02 09:02:28'),(9,11,'2017-04-20 21:48:07'),(14,11,'2017-04-03 13:32:09'),(17,11,'2017-04-22 05:20:40'),(1,12,'2017-04-25 21:19:03'),(2,12,'2017-04-14 21:04:42'),(8,12,'2017-04-14 19:43:36'),(11,12,'2017-04-04 21:53:48'),(12,12,'2017-04-13 10:18:13'),(12,12,'2017-04-26 23:44:05'),(17,12,'2017-04-25 19:19:01'),(18,12,'2017-04-05 22:53:28'),(18,12,'2017-04-11 19:55:09'),(20,12,'2017-04-23 17:23:26'),(1,13,'2017-04-12 05:14:39'),(3,13,'2017-04-02 10:38:46'),(4,13,'2017-04-26 22:53:10'),(5,13,'2017-04-17 17:52:57'),(5,13,'2017-04-25 18:01:34'),(6,13,'2017-04-06 02:06:00'),(9,13,'2017-04-09 15:38:45'),(14,13,'2017-04-18 01:01:02'),(15,13,'2017-04-20 22:36:35'),(15,13,'2017-04-26 06:26:27'),(16,13,'2017-04-23 17:12:14'),(4,14,'2017-04-04 16:59:59'),(9,14,'2017-04-05 23:47:07'),(9,14,'2017-04-12 10:05:00'),(10,14,'2017-04-11 00:24:05'),(10,14,'2017-04-21 00:17:31'),(10,14,'2017-04-30 03:04:15'),(11,14,'2017-04-14 09:04:02'),(4,15,'2017-04-15 22:31:54'),(5,15,'2017-04-08 12:18:06'),(7,15,'2017-04-19 20:39:59'),(17,15,'2017-04-07 18:49:22'),(17,15,'2017-04-22 16:29:30'),(19,15,'2017-04-21 03:28:14'),(19,15,'2017-04-21 12:24:31'),(20,15,'2017-04-23 19:39:18'),(1,16,'2017-04-10 09:34:21'),(3,16,'2017-04-14 23:31:51'),(6,16,'2017-04-09 11:23:28'),(7,16,'2017-04-22 18:54:57'),(7,16,'2017-04-28 15:11:51'),(8,16,'2017-04-16 01:38:25'),(14,16,'2017-04-28 14:21:29'),(15,16,'2017-04-21 11:20:24'),(20,16,'2017-04-14 23:55:07'),(1,17,'2017-04-14 03:43:15'),(5,17,'2017-04-03 01:09:09'),(5,17,'2017-04-05 08:13:47'),(6,17,'2017-04-22 08:13:05'),(7,17,'2017-04-07 01:34:16'),(7,17,'2017-04-15 13:43:18'),(11,17,'2017-04-17 02:31:39'),(12,17,'2017-04-08 20:14:05'),(14,17,'2017-04-24 13:02:26'),(18,17,'2017-04-10 02:20:53'),(19,17,'2017-04-25 01:22:51'),(20,17,'2017-04-16 19:07:50'),(6,18,'2017-04-19 09:11:16'),(14,18,'2017-04-24 19:51:10'),(16,18,'2017-04-06 16:09:53'),(18,18,'2017-04-15 13:51:54'),(19,18,'2017-04-02 21:34:46'),(19,18,'2017-04-17 09:05:54'),(5,19,'2017-04-19 22:54:39'),(5,19,'2017-04-24 08:13:43'),(7,19,'2017-04-19 14:23:00'),(9,19,'2017-04-02 23:54:23'),(10,19,'2017-04-08 01:21:39'),(10,19,'2017-04-27 12:16:53'),(11,19,'2017-04-07 19:41:56'),(12,19,'2017-04-28 16:23:19'),(16,19,'2017-04-26 00:27:41'),(18,19,'2017-04-09 06:15:21'),(20,19,'2017-04-03 11:20:25'),(20,19,'2017-04-25 00:11:14'),(1,20,'2017-04-14 23:48:54'),(1,20,'2017-04-16 07:01:20'),(5,20,'2017-04-11 02:01:18'),(7,20,'2017-04-01 04:11:16'),(10,20,'2017-04-01 18:26:34'),(12,20,'2017-04-18 16:12:35'),(15,20,'2017-04-22 13:34:18'),(16,20,'2017-04-26 12:12:46'),(19,20,'2017-04-10 03:12:50');
/*!40000 ALTER TABLE `projectview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_esperanto_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'Technologie'),(2,'Éducation'),(3,'Gastronomie'),(4,'Musique'),(5,'Jeux'),(6,'Communauté'),(7,'Innovation'),(8,'Mode'),(9,'Design'),(10,'Sport'),(11,'Cinéma'),(12,'Littérature'),(13,'Évènementiel'),(14,'maccaron'),(15,'jogging'),(16,'chaussures'),(17,'vélo'),(18,'i-pad'),(19,'trek'),(20,'course'),(21,'nouveau'),(26,'test1,test2'),(27,'');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `paymentdate` date NOT NULL,
  `repaymentdate` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `paymentmethod_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_user_idx` (`user_id`),
  KEY `transaction_project_idx` (`project_id`),
  KEY `transaction_paymentmethod_idx` (`paymentmethod_id`),
  CONSTRAINT `transaction_paymentmethod` FOREIGN KEY (`paymentmethod_id`) REFERENCES `paymentmethod` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `transaction_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `transaction_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (1,71,'2017-04-13',NULL,8,12,3),(2,88,'2017-03-24',NULL,2,9,3),(3,38,'2017-03-05',NULL,5,5,3),(4,62,'2017-04-18',NULL,7,1,2),(5,76,'2017-04-08',NULL,6,10,3),(6,29,'2017-04-09',NULL,4,13,3),(7,96,'2017-04-10',NULL,9,6,3),(8,11,'2017-03-04',NULL,7,3,2),(9,49,'2017-04-09',NULL,2,12,3),(10,82,'2017-03-08',NULL,6,16,3),(14,100,'2016-11-06',NULL,22,2,3),(15,50,'2016-11-06',NULL,22,2,2),(16,50,'2016-11-06',NULL,22,2,2),(17,100,'2016-11-16',NULL,28,2,2),(18,1000,'2016-11-16',NULL,28,2,2),(19,77,'2016-11-24',NULL,28,2,1),(20,75,'2016-11-24',NULL,28,2,2),(21,73,'2016-11-24',NULL,28,2,2),(22,17,'2016-11-25',NULL,28,2,3),(23,1,'2016-11-25',NULL,28,2,1),(24,18,'2016-11-25',NULL,28,8,2),(25,1,'2016-11-25',NULL,28,2,1),(26,3,'2016-11-25',NULL,28,2,1),(27,1,'2016-11-25',NULL,28,8,3),(28,1,'2016-11-25',NULL,28,2,3),(29,15,'2016-12-22',NULL,28,21,1);
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `project_transactionsum_increment` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN
    UPDATE project
    SET transactionsum = transactionsum + NEW.amount
    WHERE id = NEW.project_id;
  END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `project_transactionsum_decrement` AFTER DELETE ON `transaction` FOR EACH ROW BEGIN
    UPDATE project
    SET transactionsum = transactionsum - OLD.amount
    WHERE id = OLD.project_id;
  END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(20) COLLATE utf8_esperanto_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_esperanto_ci NOT NULL,
  `firstname` varchar(20) COLLATE utf8_esperanto_ci NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(45) COLLATE utf8_esperanto_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_esperanto_ci NOT NULL,
  `adress` varchar(45) COLLATE utf8_esperanto_ci NOT NULL,
  `postcode` int(11) NOT NULL,
  `city` varchar(20) COLLATE utf8_esperanto_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `phone` varchar(11) COLLATE utf8_esperanto_ci DEFAULT NULL,
  `photo` varchar(45) COLLATE utf8_esperanto_ci DEFAULT NULL,
  `facebookid` varchar(90) COLLATE utf8_esperanto_ci DEFAULT NULL,
  `facebooktoken` varchar(255) COLLATE utf8_esperanto_ci DEFAULT NULL,
  `subscriptiondate` date NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `desactivated` tinyint(1) NOT NULL DEFAULT '0',
  `usertype_id` int(11) NOT NULL,
  `passwordrecovercode` varchar(255) COLLATE utf8_esperanto_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `user_country_idx` (`country_id`),
  KEY `user_usertype_idx` (`usertype_id`),
  CONSTRAINT `user_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_usertype` FOREIGN KEY (`usertype_id`) REFERENCES `usertype` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'password','Valentine','Quinn','1999-07-24','scelerisque.lorem.ipsum@nascetur.net','M','962-8383 Vulputate, Chemin',94024,'Blois',75,'0438909116',NULL,NULL,NULL,'2014-07-12',0,0,1,NULL),(2,'password','Mathis','Ivan','1990-11-01','Phasellus@nonante.ca','F','Appartement 896-1423 Lacinia Av.',75311,'Saint-Lô',75,'0680399980',NULL,NULL,NULL,'2017-03-04',0,0,1,NULL),(3,'password','Holcomb','Cara','1988-06-06','adipiscing@ametmetusAliquam.org','M','Appartement 210-5475 Purus, Route',56080,'Paris',75,'0265883340',NULL,NULL,NULL,'2014-09-07',0,0,1,NULL),(4,'password','Mcintyre','Duncan','1983-07-09','a.sollicitudin@laoreetlectus.com','M','Appartement 362-6091 Ante Rd.',71097,'Schiltigheim',75,'0149355894',NULL,NULL,NULL,'2016-05-23',0,0,1,NULL),(5,'password','Brennan','Todd','1994-05-03','enim@pedeblandit.ca','M','Appartement 763-8299 Ipsum Av.',71885,'Rennes',75,'0167414367',NULL,NULL,NULL,'2015-04-15',0,0,1,NULL),(6,'password','Barlow','Christopher','1995-06-09','eget@Aliquamfringilla.com','F','CP 311, 7001 Condimentum Chemin',11421,'Bayswater',75,'0125407965',NULL,NULL,NULL,'2016-12-21',0,0,1,NULL),(7,'password','Coffey','Jasmine','1987-12-24','Sed@risusIn.ca','F','7669 Ante Chemin',80050,'Port Augusta',75,'0807823772',NULL,NULL,NULL,'2015-02-08',0,0,1,NULL),(8,'password','Sheppard','Richard','1999-07-15','cursus.et@scelerisque.org','F','Appartement 281-2028 Amet Avenue',37807,'Bayonne',75,'0263849481',NULL,NULL,NULL,'2017-01-13',0,0,1,NULL),(9,'password','Dalton','Zephr','1984-03-19','risus@tincidunttempus.edu','F','5015 Aenean Rue',26072,'La Rochelle',75,'0731230276',NULL,NULL,NULL,'2016-12-18',0,0,1,NULL),(10,'password','Clark','Calvin','1987-08-05','hymenaeos.Mauris.ut@turpisNulla.com','F','708-8984 Feugiat. Chemin',81886,'Sarreguemines',75,'0926230037',NULL,NULL,NULL,'2016-04-14',0,0,1,NULL),(11,'password','Howard','Uriah','1992-07-14','vel.vulputate@Vivamuseuismod.co.uk','M','846-813 Risus Impasse',31000,'TOULOUSE',75,'0645980607',NULL,NULL,NULL,'2015-05-19',0,0,2,NULL),(12,'password','Blevins','Barrett','1997-06-29','mi@orciUtsemper.org','F','5441 Odio Route',31000,'TOULOUSE',75,'0957279666',NULL,NULL,NULL,'2014-11-16',0,0,2,NULL),(13,'password','Strong','Jessica','1998-05-18','quis.accumsan.convallis@sed.org','F','CP 542, 9456 Faucibus. Chemin',31000,'TOULOUSE',75,'0895153079',NULL,NULL,NULL,'2014-10-10',0,0,2,NULL),(14,'password','Talley','Sydnee','1991-05-23','Integer.vulputate.risus@enimCurabitur.ca','F','1112 Nisi Ave',31000,'TOULOUSE',75,'0523316537',NULL,NULL,NULL,'2016-04-07',0,0,2,NULL),(15,'password','Mcguire','Edan','1998-05-03','Morbi.neque@et.edu','M','Appartement 582-3922 Enim. Ave',31000,'TOULOUSE',75,'0323995050',NULL,NULL,NULL,'2014-07-10',0,0,2,NULL),(16,'password','Reese','Boris','1999-03-16','non@Etiambibendum.net','F','9869 Nec Route',31000,'TOULOUSE',75,'0302488461',NULL,NULL,NULL,'2016-10-07',0,0,2,NULL),(17,'password','Jensen','Echo','1991-05-07','aliquam@et.com','F','Appartement 946-8245 Quam, Rd.',31000,'TOULOUSE',75,'0442318506',NULL,NULL,NULL,'2016-03-27',0,0,2,NULL),(18,'password','Strong','Alexis','1991-09-16','vitae@Nuncsedorci.ca','M','959-7068 Donec Rue',31000,'TOULOUSE',75,'0906426797',NULL,NULL,NULL,'2014-10-20',0,0,2,NULL),(19,'password','Hubbard','Lance','1980-10-02','Donec@elitpretiumet.edu','M','288-9109 Nec Route',31000,'TOULOUSE',75,'0892226795',NULL,NULL,NULL,'2014-06-04',0,0,2,NULL),(20,'password','Everett','Stewart','1996-03-14','natoque@leoCrasvehicula.ca','F','Appartement 538-292 Urna. Impasse',31000,'TOULOUSE',75,'0182628188',NULL,NULL,NULL,'2014-09-14',0,0,2,NULL),(21,'password','Valentin','Quinn','1999-07-24','admin@gmail.com','M','962-8383 Vulputate, Chemin',94024,'Blois',75,'0438909116',NULL,NULL,NULL,'2014-07-12',0,0,3,NULL),(22,'password','lkj','mklj,','1988-10-21','test@test.com','M','dsfmlk',31400,'Toulouse',75,'671608526','',NULL,NULL,'2016-11-06',1,0,1,NULL),(28,'As353,13','Asensi','Samuel','1988-10-21','asensi.samuel@gmail.com','M','qsdkj',31400,'Toulouse',1,'',NULL,'10209584987294564','EAAZAAF1611MoBAIf57kqsexbRO18nZCZBDSArt3RJ3wEOTjM8REuBwFFzqagANqmETkGZAznTejkSZBbb7JcwPhagqBliPX11ZBmNUCixlFa63EHeU3jEi4MTCZCsdfUmdBFbVC269yKSY3mHJ0BYBT','2016-11-16',1,0,1,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'financeur'),(2,'créateur'),(3,'administrateur');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_esperanto_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `video_project_idx` (`project_id`),
  CONSTRAINT `video_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video`
--

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
INSERT INTO `video` VALUES (1,'video/placeholder.mp4',9),(2,'video/placeholder.mp4',7),(3,'video/placeholder.mp4',3),(4,'video/placeholder.mp4',16),(5,'video/placeholder.mp4',8),(6,'video/placeholder.mp4',2),(7,'video/placeholder.mp4',7),(8,'video/placeholder.mp4',8),(9,'video/placeholder.mp4',17),(10,'video/placeholder.mp4',17),(11,'video/placeholder.mp4',14),(12,'video/placeholder.mp4',14),(13,'video/placeholder.mp4',19),(14,'video/placeholder.mp4',11),(15,'video/placeholder.mp4',7),(16,'video/placeholder.mp4',4),(17,'video/placeholder.mp4',5),(18,'video/placeholder.mp4',13),(19,'video/placeholder.mp4',12),(20,'video/placeholder.mp4',6);
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-17 17:36:13
