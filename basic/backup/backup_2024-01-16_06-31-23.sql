-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: daw2_2023_03_organizacion_torneos
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
-- Current Database: `daw2_2023_03_organizacion_torneos`
--

/*!40000 DROP DATABASE IF EXISTS `daw2_2023_03_organizacion_torneos`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `daw2_2023_03_organizacion_torneos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `daw2_2023_03_organizacion_torneos`;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','2',NULL),('gestor','4',NULL),('organizador','3',NULL),('sysadmin','1',NULL),('usuario','5',NULL),('usuario','6',NULL),('usuario','7',NULL),('usuario','8',NULL);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,'Administrador del sistema',NULL,NULL,NULL,NULL),('gestor',1,'Usuario registrado que gestiona equipos',NULL,NULL,NULL,NULL),('organizador',1,'Usuario registrado que organiza torneos',NULL,NULL,NULL,NULL),('sysadmin',1,'Tiene acceso a absolutamente todo',NULL,NULL,NULL,NULL),('usuario',1,'Usuario registrado que participa en torneos',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('admin','gestor'),('admin','organizador'),('admin','usuario'),('sysadmin','admin'),('sysadmin','gestor'),('sysadmin','organizador'),('sysadmin','usuario');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `edad_min` int(11) NOT NULL,
  `edad_max` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Infantil',6,12),(2,'Juvenil',13,18),(3,'Adulto',19,99);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clase`
--

DROP TABLE IF EXISTS `clase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clase` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `imagen_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imagen_id` (`imagen_id`),
  CONSTRAINT `clase_ibfk_1` FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Por ej: Campeonato Nacional';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clase`
--

LOCK TABLES `clase` WRITE;
/*!40000 ALTER TABLE `clase` DISABLE KEYS */;
INSERT INTO `clase` VALUES (1,'Campeonato Nacional','Torneo de alto nivel nacional',1),(2,'Torneo Local','Competición a nivel local',2),(3,'Copa Internacional','Torneo con equipos de diferentes países',3);
/*!40000 ALTER TABLE `clase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direccion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `calle` varchar(100) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `cod_postal` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calle` (`calle`,`numero`,`cod_postal`,`ciudad`,`provincia`,`pais`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` VALUES (9,'Avenida Secundaria',23,54321,'Ciudad B','Provincia Z','País W'),(1,'Calle Principal',NULL,123456789,'A','B','C'),(29,'Calle Principal',23,123456789,'A','B','C'),(11,'das',NULL,2,'das','fasd','fsd'),(3,'DASDAS',3,4,'543','34','2'),(4,'fasd',2,2,'dsa','das','das'),(2,'Pl. Humedal',NULL,33206,'Gijón','Asturias','España'),(8,'Plaza España',NULL,49123,'Madrid','Madrid','España'),(10,'Plaza España',123456,49123,'Madrid','Madrid','España'),(23,'Sample Street',123,12345,'Sample City','Sample Province','Sample Country'),(27,'San Lázaro',NULL,49123,'Madrid','Madrid','España'),(25,'San Lázaro',20,49123,'Madrid','Madrid','España'),(13,'Street A',101,54321,'City A','Province A','Country A'),(14,'Street B',202,98765,'City B','Province B','Country B'),(15,'Street C',303,12345,'City C','Province C','Country C'),(16,'Street D',404,67890,'City D','Province D','Country D'),(17,'Street E',505,11111,'City E','Province E','Country E'),(18,'Street F',606,99999,'City F','Province F','Country F'),(19,'Street G',707,77777,'City G','Province G','Country G'),(20,'Street H',808,33333,'City H','Province H','Country H'),(21,'Street I',909,55555,'City I','Province I','Country I'),(22,'Street J',1010,44444,'City J','Province J','Country J');
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disciplina`
--

DROP TABLE IF EXISTS `disciplina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disciplina` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Por ej si el torneo es de fútbol, baloncesto...';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disciplina`
--

LOCK TABLES `disciplina` WRITE;
/*!40000 ALTER TABLE `disciplina` DISABLE KEYS */;
INSERT INTO `disciplina` VALUES (1,'Fútbol','Deporte de equipo con un balón'),(2,'Baloncesto','Deporte de equipo con una pelota naranja'),(3,'Tenis','Deporte de raqueta individual');
/*!40000 ALTER TABLE `disciplina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documento`
--

DROP TABLE IF EXISTS `documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ruta` (`ruta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento`
--

LOCK TABLES `documento` WRITE;
/*!40000 ALTER TABLE `documento` DISABLE KEYS */;
INSERT INTO `documento` VALUES (1,'/documentos/doc1.pdf'),(2,'/documentos/doc2.pdf'),(3,'/documentos/doc3.pdf');
/*!40000 ALTER TABLE `documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(10000) DEFAULT NULL,
  `licencia` varchar(250) NOT NULL COMMENT 'Numero de licencia',
  `categoria_id` bigint(20) NOT NULL,
  `creador_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `fk_equipo_creador_id` (`creador_id`),
  CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  CONSTRAINT `fk_equipo_creador_id` FOREIGN KEY (`creador_id`) REFERENCES `participante` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES (1,'Equipo A','Descripción del Equipo A','ABC123',1,1),(2,'Equipo B','Descripción del Equipo B','XYZ789',2,NULL),(3,'Equipo C','Descripción del Equipo C','DEF456',3,NULL);
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo_participante`
--

DROP TABLE IF EXISTS `equipo_participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipo_participante` (
  `equipo_id` bigint(20) NOT NULL,
  `participante_id` bigint(20) NOT NULL,
  PRIMARY KEY (`participante_id`,`equipo_id`),
  KEY `equipo_id` (`equipo_id`),
  CONSTRAINT `equipo_participante_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  CONSTRAINT `equipo_participante_ibfk_2` FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo_participante`
--

LOCK TABLES `equipo_participante` WRITE;
/*!40000 ALTER TABLE `equipo_participante` DISABLE KEYS */;
INSERT INTO `equipo_participante` VALUES (1,1),(2,2),(3,3);
/*!40000 ALTER TABLE `equipo_participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagen`
--

DROP TABLE IF EXISTS `imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ruta` (`ruta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagen`
--

LOCK TABLES `imagen` WRITE;
/*!40000 ALTER TABLE `imagen` DISABLE KEYS */;
INSERT INTO `imagen` VALUES (1,'/imagenes/img1.jpg'),(2,'/imagenes/img2.jpg'),(3,'/imagenes/img3.jpg');
/*!40000 ALTER TABLE `imagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(10) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prefix` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=638 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material`
--

LOCK TABLES `material` WRITE;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` VALUES (1,'Balón','Blanco y negro','Balón de fútbol'),(2,'Raqueta','Rojo','Raqueta de tenis'),(3,'Silbato','Plateado','Silbato para árbitro');
/*!40000 ALTER TABLE `material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `normativa`
--

DROP TABLE IF EXISTS `normativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `normativa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `documento_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `documento_id` (`documento_id`),
  CONSTRAINT `normativa_ibfk_1` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `normativa`
--

LOCK TABLES `normativa` WRITE;
/*!40000 ALTER TABLE `normativa` DISABLE KEYS */;
INSERT INTO `normativa` VALUES (1,'Normativa 1','Descripción de la normativa 1',1),(2,'Normativa 2','Descripción de la normativa 2',2),(3,'Normativa 3','Descripción de la normativa 3',3);
/*!40000 ALTER TABLE `normativa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participante` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha_nacimiento` date NOT NULL,
  `licencia` varchar(250) NOT NULL,
  `tipo_participante_id` bigint(20) NOT NULL,
  `imagen_id` bigint(20) DEFAULT NULL,
  `usuario_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `licencia` (`licencia`),
  KEY `tipo_participante_id` (`tipo_participante_id`),
  KEY `imagen_id` (`imagen_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `participante_ibfk_1` FOREIGN KEY (`tipo_participante_id`) REFERENCES `tipo_participante` (`id`),
  CONSTRAINT `participante_ibfk_2` FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`),
  CONSTRAINT `participante_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (1,'1990-05-15','ABC123',1,NULL,6),(2,'1985-12-10','XYZ789',2,NULL,7),(3,'1995-08-22','DEF456',3,NULL,8);
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante_documento`
--

DROP TABLE IF EXISTS `participante_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participante_documento` (
  `participante_id` bigint(20) NOT NULL,
  `documento_id` bigint(20) NOT NULL,
  PRIMARY KEY (`participante_id`,`documento_id`),
  KEY `documento_id` (`documento_id`),
  CONSTRAINT `participante_documento_ibfk_1` FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`),
  CONSTRAINT `participante_documento_ibfk_2` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante_documento`
--

LOCK TABLES `participante_documento` WRITE;
/*!40000 ALTER TABLE `participante_documento` DISABLE KEYS */;
INSERT INTO `participante_documento` VALUES (1,1),(2,2),(3,3);
/*!40000 ALTER TABLE `participante_documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partido`
--

DROP TABLE IF EXISTS `partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partido` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jornada` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `torneo_id` bigint(20) NOT NULL,
  `reserva_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `torneo_id` (`torneo_id`),
  KEY `reserva_id` (`reserva_id`),
  CONSTRAINT `partido_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`),
  CONSTRAINT `partido_ibfk_2` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partido`
--

LOCK TABLES `partido` WRITE;
/*!40000 ALTER TABLE `partido` DISABLE KEYS */;
INSERT INTO `partido` VALUES (1,1,'2024-01-31 23:00:00',1,1),(2,1,'2024-01-15 23:37:23',2,2),(3,3,'2024-01-15 18:13:23',3,NULL);
/*!40000 ALTER TABLE `partido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partido_equipo`
--

DROP TABLE IF EXISTS `partido_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partido_equipo` (
  `partido_id` bigint(20) NOT NULL,
  `equipo_id` bigint(20) NOT NULL,
  `puntos` int(11) DEFAULT NULL COMMENT 'Puntos de ese equipo en ese partido',
  PRIMARY KEY (`partido_id`,`equipo_id`),
  KEY `equipo_id` (`equipo_id`),
  CONSTRAINT `partido_equipo_ibfk_1` FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`),
  CONSTRAINT `partido_equipo_ibfk_2` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partido_equipo`
--

LOCK TABLES `partido_equipo` WRITE;
/*!40000 ALTER TABLE `partido_equipo` DISABLE KEYS */;
INSERT INTO `partido_equipo` VALUES (1,1,3),(1,2,1),(2,3,2);
/*!40000 ALTER TABLE `partido_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pista`
--

DROP TABLE IF EXISTS `pista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pista` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `disciplina_id` bigint(20) NOT NULL,
  `direccion_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `direccion_id` (`direccion_id`),
  KEY `disciplina_id` (`disciplina_id`),
  CONSTRAINT `pista_ibfk_1` FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`),
  CONSTRAINT `pista_ibfk_2` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pista`
--

LOCK TABLES `pista` WRITE;
/*!40000 ALTER TABLE `pista` DISABLE KEYS */;
INSERT INTO `pista` VALUES (1,'Pista 1','afhjksdgsssssssssssssssssssssssssssssssssssssssgfhjasfasdfhagdhjgfhjasgfhjasdgfjkgsdhjkfgasdhjkfgasd',1,10),(2,'Pista 2 editada 222','Descripción de la Pista 2',2,9),(3,'Pista 3','Descripción de la Pista 3',3,1),(4,'pista prueba 1','fsdafdsf',2,3),(5,'fasdf','fasdfds',3,4),(18,'Pista d1','Description 1',2,3),(19,'Pista dsa2','Description 2',1,2),(20,'Pista d3','Description 3',3,1),(21,'Pista 4','Description 4',2,2),(22,'Pista d5','Description 5',1,3),(23,'Pista d6','Description 6',3,3),(24,'Pista A','Description A',2,3),(25,'Pista B','Description B',1,2),(26,'Pista C','Description C',3,1),(27,'Pista D','Description D',2,2),(28,'Pista E','Description E',1,3),(29,'Pista F','Description F',3,3),(30,'Pista G','Description G',1,1),(31,'Pista H','Description H',3,2),(40,'sddads','ffasd',2,1),(41,'Tennis Court Alpha','Description for Tennis Court Alpha',1,1),(42,'Soccer Field Beta','Description for Soccer Field Beta',2,1),(43,'Basketball Arena Gamma','Description for Basketball Arena Gamma',3,1),(44,'Running Track Delta','Description for Running Track Delta',1,1),(45,'Swimming Pool Epsilon','Description for Swimming Pool Epsilon',2,1),(46,'Volleyball Court Zeta','Description for Volleyball Court Zeta',3,1);
/*!40000 ALTER TABLE `pista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `premio`
--

DROP TABLE IF EXISTS `premio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premio` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL COMMENT 'trofeo',
  `descripcion` varchar(500) DEFAULT NULL,
  `categoria_id` bigint(20) NOT NULL,
  `torneo_id` bigint(20) NOT NULL,
  `equipo_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `categoria_id` (`categoria_id`),
  KEY `torneo_id` (`torneo_id`),
  KEY `equipo_id` (`equipo_id`),
  CONSTRAINT `premio_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  CONSTRAINT `premio_ibfk_2` FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`),
  CONSTRAINT `premio_ibfk_3` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `premio`
--

LOCK TABLES `premio` WRITE;
/*!40000 ALTER TABLE `premio` DISABLE KEYS */;
INSERT INTO `premio` VALUES (1,'Trofeo 1','Descripción del trofeo 1',1,1,1),(2,'Trofeo 2','Descripción del trofeo 2',2,2,2),(3,'Trofeo 3','Descripción del trofeo 3',3,3,3);
/*!40000 ALTER TABLE `premio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,'2024-01-15',1),(2,'2024-02-20',2),(3,'2024-03-25',1),(4,'2024-01-03',1),(5,'2024-01-17',1),(6,'2024-01-02',1),(7,'2024-01-04',1),(11,'2024-01-03',1),(13,'2024-01-31',1),(14,'2024-01-30',1),(15,'2024-01-25',1),(16,'2024-01-26',1),(17,'2024-01-19',1),(18,'2024-01-20',1),(19,'2024-01-21',1),(20,'2024-01-27',1),(21,'2024-01-28',1),(22,'2024-01-31',1);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva_material`
--

DROP TABLE IF EXISTS `reserva_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva_material` (
  `reserva_id` bigint(20) NOT NULL,
  `material_id` bigint(20) NOT NULL,
  PRIMARY KEY (`reserva_id`,`material_id`),
  KEY `material_id` (`material_id`),
  CONSTRAINT `reserva_material_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`),
  CONSTRAINT `reserva_material_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva_material`
--

LOCK TABLES `reserva_material` WRITE;
/*!40000 ALTER TABLE `reserva_material` DISABLE KEYS */;
INSERT INTO `reserva_material` VALUES (1,1),(2,2),(3,3),(11,2);
/*!40000 ALTER TABLE `reserva_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva_pista`
--

DROP TABLE IF EXISTS `reserva_pista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva_pista` (
  `reserva_id` bigint(20) NOT NULL,
  `pista_id` bigint(20) NOT NULL,
  PRIMARY KEY (`reserva_id`,`pista_id`),
  KEY `pista_id` (`pista_id`),
  CONSTRAINT `reserva_pista_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`),
  CONSTRAINT `reserva_pista_ibfk_2` FOREIGN KEY (`pista_id`) REFERENCES `pista` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva_pista`
--

LOCK TABLES `reserva_pista` WRITE;
/*!40000 ALTER TABLE `reserva_pista` DISABLE KEYS */;
INSERT INTO `reserva_pista` VALUES (1,1),(1,2),(1,18),(2,1),(2,2),(2,4),(2,19),(3,1),(3,3),(3,20),(4,1),(4,21),(5,1),(5,2),(5,22),(6,1),(6,23),(7,1),(7,2),(7,18),(7,19),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,1);
/*!40000 ALTER TABLE `reserva_pista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_participante`
--

DROP TABLE IF EXISTS `tipo_participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_participante` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_participante`
--

LOCK TABLES `tipo_participante` WRITE;
/*!40000 ALTER TABLE `tipo_participante` DISABLE KEYS */;
INSERT INTO `tipo_participante` VALUES (1,'Jugador','Participante que juega en equipos'),(2,'Delegado de equipo','Oficial encargado del equipo'),(3,'Entrenador','Persona a cargo del entrenamiento del equipo');
/*!40000 ALTER TABLE `tipo_participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_torneo`
--

DROP TABLE IF EXISTS `tipo_torneo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_torneo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Por ej: Triangular';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_torneo`
--

LOCK TABLES `tipo_torneo` WRITE;
/*!40000 ALTER TABLE `tipo_torneo` DISABLE KEYS */;
INSERT INTO `tipo_torneo` VALUES (1,'Eliminatorias'),(2,'Liga'),(3,'Torneo amistoso');
/*!40000 ALTER TABLE `tipo_torneo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo`
--

DROP TABLE IF EXISTS `torneo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torneo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `participantes_max` int(11) NOT NULL,
  `disciplina_id` bigint(20) NOT NULL,
  `tipo_torneo_id` bigint(20) NOT NULL,
  `clase_id` bigint(20) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_limite` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disciplina_id` (`disciplina_id`),
  KEY `tipo_torneo_id` (`tipo_torneo_id`),
  KEY `clase_id` (`clase_id`),
  CONSTRAINT `torneo_ibfk_1` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`),
  CONSTRAINT `torneo_ibfk_2` FOREIGN KEY (`tipo_torneo_id`) REFERENCES `tipo_torneo` (`id`),
  CONSTRAINT `torneo_ibfk_3` FOREIGN KEY (`clase_id`) REFERENCES `clase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla principal de torneo';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo`
--

LOCK TABLES `torneo` WRITE;
/*!40000 ALTER TABLE `torneo` DISABLE KEYS */;
INSERT INTO `torneo` VALUES (1,'Torneo de Fútbol','Torneo de fútbol a nivel nacional',16,1,1,1,'2024-01-10 12:08:54','2024-01-09 12:08:54',NULL),(2,'Torneo de Baloncesto','Torneo de baloncesto juvenil',12,2,2,2,'2024-01-10 12:08:54','2024-01-09 12:08:54',NULL),(3,'Torneo de Tenis','Torneo de tenis individual',32,3,3,3,'2024-01-10 12:08:54','2024-01-09 12:08:54',NULL),(4,'Torneo1','Descripción del Torneo 1',50,1,1,1,'2024-01-23 09:59:19','2024-01-23 09:59:19','2024-01-29 09:59:19'),(5,'Torneo2','Descripción del Torneo 2',40,2,2,2,'2024-02-01 09:59:19','2024-01-27 09:59:19','2024-01-25 09:59:19'),(6,'Torneo3','Descripción del Torneo 3',30,3,3,3,'2024-01-28 09:59:19','2024-01-21 09:59:19','2024-02-03 09:59:19'),(7,'Torneo4','Descripción del Torneo 4',25,1,2,3,'2024-02-02 09:59:19','2024-01-18 09:59:19','2024-02-06 09:59:19'),(8,'Torneo5','Descripción del Torneo 5',35,2,1,2,'2024-01-22 09:59:19','2024-02-13 09:59:19','2024-01-18 09:59:19'),(9,'Torneo6','Descripción del Torneo 6',20,3,3,1,'2024-02-03 09:59:19','2024-02-09 09:59:19','2024-01-23 09:59:19'),(10,'Torneo7','Descripción del Torneo 7',45,1,2,2,'2024-02-09 09:59:19','2024-01-25 09:59:19','2024-01-17 09:59:19'),(11,'Torneo8','Descripción del Torneo 8',30,2,1,3,'2024-01-28 09:59:19','2024-02-11 09:59:19','2024-01-21 09:59:19'),(12,'Torneo9','Descripción del Torneo 9',25,3,3,1,'2024-01-24 09:59:19','2024-02-08 09:59:19','2024-01-19 09:59:19'),(13,'Torneo10','Descripción del Torneo 10',40,1,1,2,'2024-01-20 09:59:19','2024-01-31 09:59:19','2024-01-16 09:59:19'),(14,'Torneo11','Descripción del Torneo 11',35,2,2,3,'2024-02-04 09:59:19','2024-01-20 09:59:19','2024-02-08 09:59:19'),(15,'Torneo12','Descripción del Torneo 12',20,3,1,1,'2024-02-01 09:59:19','2024-01-26 09:59:19','2024-01-19 09:59:19'),(16,'Torneo13','Descripción del Torneo 13',45,1,3,2,'2024-01-31 09:59:19','2024-01-24 09:59:19','2024-02-12 09:59:19'),(17,'Torneo14','Descripción del Torneo 14',30,2,1,3,'2024-02-03 09:59:19','2024-01-26 09:59:19','2024-02-11 09:59:19'),(18,'Torneo15','Descripción del Torneo 15',25,3,2,1,'2024-01-29 09:59:19','2024-02-02 09:59:19','2024-01-31 09:59:19'),(19,'Torneo16','Descripción del Torneo 16',40,1,1,2,'2024-02-09 09:59:19','2024-01-31 09:59:19','2024-01-21 09:59:19'),(20,'Torneo17','Descripción del Torneo 17',35,2,2,3,'2024-01-28 09:59:19','2024-01-30 09:59:19','2024-01-20 09:59:19'),(21,'Torneo18','Descripción del Torneo 18',20,3,1,1,'2024-01-26 09:59:19','2024-01-23 09:59:19','2024-01-21 09:59:19'),(22,'Torneo19','Descripción del Torneo 19',45,1,3,2,'2024-01-23 09:59:19','2024-02-03 09:59:19','2024-01-25 09:59:19');
/*!40000 ALTER TABLE `torneo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo_categoria`
--

DROP TABLE IF EXISTS `torneo_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torneo_categoria` (
  `torneo_id` bigint(20) NOT NULL,
  `categoria_id` bigint(20) NOT NULL,
  PRIMARY KEY (`torneo_id`,`categoria_id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `torneo_categoria_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`),
  CONSTRAINT `torneo_categoria_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo_categoria`
--

LOCK TABLES `torneo_categoria` WRITE;
/*!40000 ALTER TABLE `torneo_categoria` DISABLE KEYS */;
INSERT INTO `torneo_categoria` VALUES (1,1),(2,2),(3,3);
/*!40000 ALTER TABLE `torneo_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo_equipo`
--

DROP TABLE IF EXISTS `torneo_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torneo_equipo` (
  `torneo_id` bigint(20) NOT NULL,
  `equipo_id` bigint(20) NOT NULL,
  PRIMARY KEY (`torneo_id`,`equipo_id`),
  KEY `equipo_id` (`equipo_id`),
  CONSTRAINT `torneo_equipo_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`),
  CONSTRAINT `torneo_equipo_ibfk_2` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo_equipo`
--

LOCK TABLES `torneo_equipo` WRITE;
/*!40000 ALTER TABLE `torneo_equipo` DISABLE KEYS */;
INSERT INTO `torneo_equipo` VALUES (1,1),(2,2),(3,3),(6,1),(10,1);
/*!40000 ALTER TABLE `torneo_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo_imagen`
--

DROP TABLE IF EXISTS `torneo_imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torneo_imagen` (
  `torneo_id` bigint(20) NOT NULL,
  `imagen_id` bigint(20) NOT NULL,
  PRIMARY KEY (`torneo_id`,`imagen_id`),
  KEY `imagen_id` (`imagen_id`),
  CONSTRAINT `torneo_imagen_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`),
  CONSTRAINT `torneo_imagen_ibfk_2` FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo_imagen`
--

LOCK TABLES `torneo_imagen` WRITE;
/*!40000 ALTER TABLE `torneo_imagen` DISABLE KEYS */;
/*!40000 ALTER TABLE `torneo_imagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo_normativa`
--

DROP TABLE IF EXISTS `torneo_normativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torneo_normativa` (
  `torneo_id` bigint(20) NOT NULL,
  `normativa_id` bigint(20) NOT NULL,
  PRIMARY KEY (`torneo_id`,`normativa_id`),
  KEY `normativa_id` (`normativa_id`),
  CONSTRAINT `torneo_normativa_ibfk_1` FOREIGN KEY (`torneo_id`) REFERENCES `torneo` (`id`),
  CONSTRAINT `torneo_normativa_ibfk_2` FOREIGN KEY (`normativa_id`) REFERENCES `normativa` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo_normativa`
--

LOCK TABLES `torneo_normativa` WRITE;
/*!40000 ALTER TABLE `torneo_normativa` DISABLE KEYS */;
/*!40000 ALTER TABLE `torneo_normativa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Juan','Pérez','Gómez','juan@example.com','123'),(2,'María','García','López','maria@example.com','1234'),(3,'Pedro','Martínez','Sánchez','pedrito@example.com','12345'),(4,'Ana','Rodríguez','Fernández','anita@example.com','123456'),(5,'Luis','González','García','surluisito29@example.com','1234567'),(6,'Sara','Sánchez','Gómez','sara@example.com','12345678'),(7,'Carlos','Romero','García','carlos@example.com','12345678'),(8,'Laura','Sanz','Gómez','laurina@example.com','12345678'),(9,'Javier','Torres','García','javi@example.com','12345678');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-16  6:31:23
