-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: loja_wow
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `encomendas`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encomendas` (
  `id_encomenda` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `nome_utilizador` varchar(45) NOT NULL,
  `data_nascimento` date NOT NULL,
  `morada` varchar(255) NOT NULL,
  `produtos_comprados` text,
  `preco_total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_encomenda`),
  UNIQUE KEY `id_encomenda_UNIQUE` (`id_encomenda`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `encomendas_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id_utilizadores`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encomendas`
--

LOCK TABLES `encomendas` WRITE;
/*!40000 ALTER TABLE `encomendas` DISABLE KEYS */;
INSERT INTO `encomendas` VALUES (20,24,'Bruno','2003-12-12','sadasd','Produto: 5, Quantidade: 1; ',80.00),(21,24,'teste da silva','2003-12-12','Casa dos anjos','Produto: 24, Quantidade: ; Produto: 5, Quantidade: 1; Produto: 8, Quantidade: 1; ',1280.00);
/*!40000 ALTER TABLE `encomendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(255) NOT NULL,
  `quantidade` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  UNIQUE KEY `id_produto` (`id_produto`),
  UNIQUE KEY `nome_produto` (`nome_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Transmog Druida',0,50.00,'../img/transmog-druida.jpg'),(5,'Transmog DK',2,80.00,'../img/dk-transmog.jpg'),(6,'Set transmog: Holy paladin ',5,25.00,'../img/paladin-transmog.jpg'),(7,'Set transmog: Hunter',3,25.00,'../img/transmog-hunter.jpg'),(8,'SHADOWMOURNE',1,1200.00,'../img/shadowmourne.png');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos_encomendados`
--

DROP TABLE IF EXISTS `produtos_encomendados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos_encomendados` (
  `id_encomenda` int DEFAULT NULL,
  `id_produto` int DEFAULT NULL,
  `quantidade` int NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  KEY `id_encomenda` (`id_encomenda`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `produtos_encomendados_ibfk_1` FOREIGN KEY (`id_encomenda`) REFERENCES `encomendas` (`id_encomenda`),
  CONSTRAINT `produtos_encomendados_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos_encomendados`
--

LOCK TABLES `produtos_encomendados` WRITE;
/*!40000 ALTER TABLE `produtos_encomendados` DISABLE KEYS */;
/*!40000 ALTER TABLE `produtos_encomendados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizadores` (
  `id_utilizadores` int NOT NULL AUTO_INCREMENT,
  `nome_utilizador` varchar(45) NOT NULL,
  `senha` varchar(1000) NOT NULL,
  `email` varchar(45) NOT NULL,
  `privilegios` int DEFAULT '0',
  PRIMARY KEY (`id_utilizadores`),
  UNIQUE KEY `nome_utilizador_UNIQUE` (`nome_utilizador`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadores`
--

LOCK TABLES `utilizadores` WRITE;
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` VALUES (1,'Bruno','$2y$10$KOZW29JuvE6R.m0fzkwXQe/MkERukqfhbsK1uuvalopcxlFW4NjuO','brunoteste@gmail.com',0),(3,'admin','$2y$10$anxjDK/B47BBioa5Fh3BKOFLnCojoE/wFm5tOzPMb0u5whECFTPOm','admin@masterd.com',1),(23,'Beatriz','$2y$10$ZIK9RdqcvIXfW62EK2tynerhATI6z4hhpHF7IrBpdfNuibS1Fuvbq','beatrizteste@gmail.com',0),(24,'teste123','$2y$10$OTujT5i.5Mx5wvn9xFprP.C8LJ1Kp5TZYVGKt9/ev4m8F0sFmVNAu','teste123@gmail.com',0);
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-14 17:07:05
