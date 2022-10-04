-- MySQL dump 10.13  Distrib 8.0.24, for macos11 (x86_64)
--
-- Host: localhost    Database: locautoV2bis
-- ------------------------------------------------------
-- Server version	5.5.5-10.5.9-MariaDB

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
-- Table structure for table `Categorie`
--

DROP TABLE IF EXISTS `Categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categorie` (
  `id_categorie` varchar(1) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categorie`
--

LOCK TABLES `Categorie` WRITE;
/*!40000 ALTER TABLE `Categorie` DISABLE KEYS */;
INSERT INTO `Categorie` VALUES ('A','Citadine',60),('B','Economique',72),('C','Compact',80),('D','Intermédiaire',95),('E','Berline',120),('F','Grande berline',150),('G','Sport SUV',230),('V','Luxe',350);
/*!40000 ALTER TABLE `Categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Client`
--

DROP TABLE IF EXISTS `Client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `id_type_de_client` int(11) NOT NULL,
  PRIMARY KEY (`id_client`),
  KEY `Client_Type_de_client_FK` (`id_type_de_client`),
  CONSTRAINT `Client_Type_de_client_FK` FOREIGN KEY (`id_type_de_client`) REFERENCES `Type_de_client` (`id_type_de_client`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Client`
--

LOCK TABLES `Client` WRITE;
/*!40000 ALTER TABLE `Client` DISABLE KEYS */;
INSERT INTO `Client` VALUES (1,'malkovitch','john','paradise street',1),(2,'smith','bill','hell. city',2),(3,'murray','bill','les fleurs du mal',3),(4,'nature','gwendal','rennes',1);
/*!40000 ALTER TABLE `Client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Location`
--

DROP TABLE IF EXISTS `Location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Location` (
  `id_location` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `compteur_debut` int(11) NOT NULL,
  `compteur_fin` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL,
  PRIMARY KEY (`id_location`),
  KEY `Location_Client_FK` (`id_client`),
  KEY `Location_Voiture0_FK` (`id_voiture`),
  CONSTRAINT `Location_Client_FK` FOREIGN KEY (`id_client`) REFERENCES `Client` (`id_client`),
  CONSTRAINT `Location_Voiture0_FK` FOREIGN KEY (`id_voiture`) REFERENCES `Voiture` (`id_voiture`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Location`
--

LOCK TABLES `Location` WRITE;
/*!40000 ALTER TABLE `Location` DISABLE KEYS */;
INSERT INTO `Location` VALUES (1,'2022-01-01','2022-01-02',2001,2055,1,1),(2,'2022-03-01','2022-03-02',19345,19867,1,4),(3,'2022-03-30','2022-04-01',6453,6548,2,11),(4,'2022-01-15','2022-01-18',6345,6543,2,16);
/*!40000 ALTER TABLE `Location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Marque`
--

DROP TABLE IF EXISTS `Marque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Marque` (
  `id_marque` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Marque`
--

LOCK TABLES `Marque` WRITE;
/*!40000 ALTER TABLE `Marque` DISABLE KEYS */;
INSERT INTO `Marque` VALUES (1,'Alfa Romeo'),(2,'Ford'),(3,'BMW'),(4,'Volkswagen'),(5,'Peugeot'),(6,'Fiat'),(7,'Mercedes'),(8,'Infinity'),(9,'Opel'),(10,'Smart'),(11,'Skoda'),(12,'Jaguar'),(13,'Mini'),(14,'Porsche'),(15,'Citroen');
/*!40000 ALTER TABLE `Marque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Modele`
--

DROP TABLE IF EXISTS `Modele`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Modele` (
  `id_modele` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `id_categorie` varchar(1) NOT NULL,
  `id_marque` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id_modele`),
  KEY `Modele_Categorie_FK` (`id_categorie`),
  KEY `Modele_Marque0_FK` (`id_marque`),
  CONSTRAINT `Modele_Categorie_FK` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`),
  CONSTRAINT `Modele_Marque0_FK` FOREIGN KEY (`id_marque`) REFERENCES `Marque` (`id_marque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Modele`
--

LOCK TABLES `Modele` WRITE;
/*!40000 ALTER TABLE `Modele` DISABLE KEYS */;
INSERT INTO `Modele` VALUES (1,'Giulietta','D',1,'alfa-romeo-giulietta.jpg'),(2,'S-MAX','E',2,'ford-smax.jpg'),(3,'Série 3','D',3,'bmw-3.jpg'),(4,'Série 7','F',3,'bmw-7.jpg'),(5,'Polo','B',4,'vw-polo.jpg'),(6,'Kuga','G',2,'ford-kuga.jpg'),(7,'308','B',5,'peugeot-308.jpg'),(8,'Cinquecento','A',6,'fiat-500.jpg'),(9,'Classe E','F',7,'mercedes-e.jpg'),(10,'308 Break','C',5,'peugeot-308-break.jpg'),(11,'Q50','G',8,'infiniti-q50.jpg'),(12,'X5','V',3,'bmw-x5.jpg'),(13,'Astra Break','D',9,'opel-astra-break.jpg'),(14,'For Two','A',10,'smart-fortwo.jpg'),(15,'Classe B','E',7,'mercedes-b.jpg'),(16,'C-Max','D',2,'ford-cmax.jpg'),(17,'Passat Break','C',4,'vw-passat-break.jpg'),(18,'Jumpy 9 places','E',15,'citroen-jumpy.jpg'),(19,'Octavia Break','D',11,'skoda-octavia-break.jpg'),(20,'3008','D',5,'peugeot-3008.jpg'),(21,'X1','G',3,'bmw-x1.jpg'),(22,'Scirocco','D',4,'vw-scirocco.jpg'),(23,'XF','V',12,'jaguar-xf.jpg'),(24,'Série 3 Break','E',3,'bmw-3-break.jpg'),(25,'Cooper','C',13,'mini-cooper.jpg'),(26,'Panamera','V',14,'porsche-panamera.jpg'),(27,'Cinquecento','A',6,'fiat-500.jpg');
/*!40000 ALTER TABLE `Modele` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Option`
--

DROP TABLE IF EXISTS `Option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Option` (
  `id_option` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Option`
--

LOCK TABLES `Option` WRITE;
/*!40000 ALTER TABLE `Option` DISABLE KEYS */;
INSERT INTO `Option` VALUES (1,'Assurance complémentaire',50),(2,'Nettoyage',75),(3,'Complément carburant',30),(4,'Retour autre ville',250),(5,'Rabais dimanche',-40),(6,'tout propre',100);
/*!40000 ALTER TABLE `Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Type_de_client`
--

DROP TABLE IF EXISTS `Type_de_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Type_de_client` (
  `id_type_de_client` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id_type_de_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Type_de_client`
--

LOCK TABLES `Type_de_client` WRITE;
/*!40000 ALTER TABLE `Type_de_client` DISABLE KEYS */;
INSERT INTO `Type_de_client` VALUES (1,'Particulier'),(2,'Entreprise'),(3,'Administration'),(4,'Association'),(5,'Longue duree');
/*!40000 ALTER TABLE `Type_de_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Voiture`
--

DROP TABLE IF EXISTS `Voiture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Voiture` (
  `id_voiture` int(11) NOT NULL AUTO_INCREMENT,
  `immatriculation` varchar(50) NOT NULL,
  `compteur` int(11) NOT NULL,
  `id_modele` int(11) NOT NULL,
  PRIMARY KEY (`id_voiture`),
  KEY `Voiture_Modele_FK` (`id_modele`),
  CONSTRAINT `Voiture_Modele_FK` FOREIGN KEY (`id_modele`) REFERENCES `Modele` (`id_modele`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Voiture`
--

LOCK TABLES `Voiture` WRITE;
/*!40000 ALTER TABLE `Voiture` DISABLE KEYS */;
INSERT INTO `Voiture` VALUES (1,'123 ABC 456',2055,1),(2,'215 QKX 284',27655,2),(3,'234 ATV 765',5789,3),(4,'238 SFG 387',19867,4),(5,'241 GST 356',21765,5),(6,'293 LXU 428',3682,6),(7,'349 DES 974',6548,7),(8,'426 DEH 935',12546,8),(9,'427 XHQ 765',23768,9),(10,'470 DKJ 639',28476,10),(11,'537 QSD 276',6548,11),(12,'542 SQU 387',128,12),(13,'543 KDE 735',43276,13),(14,'634 DJH 724',23102,14),(15,'654 HDY 528',8545,10),(16,'732 HFD 383',6543,14),(17,'734 SED 359',12345,7),(18,'744 HFS 296',44346,5),(19,'753 FSC 945',7654,19),(20,'753 SUR 871',21865,7),(21,'754 GYH 749',250,21),(22,'765 HDW 347',7534,22),(23,'765 KJH 364',7652,23),(24,'765 SRC 234',9864,24),(25,'853 DJY 284',76443,25),(26,'857 HDE 248',7538,26),(27,'863 NBS 738',28765,8),(28,'864 LQD 482',7646,19),(29,'865 KSC 912',27486,16),(30,'873 MHF 487',76534,15),(31,'934 KDS 452',12635,17),(32,'985 FSZ 238',8543,20);
/*!40000 ALTER TABLE `Voiture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `choix_option`
--

DROP TABLE IF EXISTS `choix_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `choix_option` (
  `id_option` int(11) NOT NULL,
  `id_location` int(11) NOT NULL,
  PRIMARY KEY (`id_option`,`id_location`),
  KEY `choix_Location0_FK` (`id_location`),
  CONSTRAINT `choix_Location0_FK` FOREIGN KEY (`id_location`) REFERENCES `Location` (`id_location`),
  CONSTRAINT `choix_Option_FK` FOREIGN KEY (`id_option`) REFERENCES `Option` (`id_option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choix_option`
--

LOCK TABLES `choix_option` WRITE;
/*!40000 ALTER TABLE `choix_option` DISABLE KEYS */;
INSERT INTO `choix_option` VALUES (1,1),(3,2),(3,3),(4,4);
/*!40000 ALTER TABLE `choix_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'locautoV2bis'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-19 16:07:06
