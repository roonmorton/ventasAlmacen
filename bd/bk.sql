CREATE DATABASE  IF NOT EXISTS ventas /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE ventas;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ventas
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.11-MariaDB

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
-- Table structure for table articulos
--

DROP TABLE IF EXISTS articulos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE articulos (
  id_producto int(11) NOT NULL AUTO_INCREMENT,
  id_categoria int(11) NOT NULL,
  id_imagen int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  nombre varchar(50) DEFAULT NULL,
  descripcion varchar(500) DEFAULT NULL,
  cantidad int(11) DEFAULT NULL,
  precio float DEFAULT NULL,
  fechaCaptura date DEFAULT NULL,
  puntos int(11) DEFAULT 0,
  PRIMARY KEY (id_producto)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table articulos
--

LOCK TABLES articulos WRITE;
/*!40000 ALTER TABLE articulos DISABLE KEYS */;
INSERT INTO articulos VALUES (2,5,2,2,'Coca Cola','Bebida 16oz',854,6,'2020-10-26',100),(3,6,3,3,'Arroz ','1 Libra Arroz Diana',963,2,'2020-10-26',1),(4,4,4,3,'Fideos Molitalia','Fideos bolsa 250g ',974,2,'2020-10-30',2);
/*!40000 ALTER TABLE articulos ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table caja
--

DROP TABLE IF EXISTS caja;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE caja (
  idCaja int(11) NOT NULL AUTO_INCREMENT,
  num int(11) DEFAULT NULL,
  descripcion varchar(75) DEFAULT NULL,
  PRIMARY KEY (idCaja)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table caja
--

LOCK TABLES caja WRITE;
/*!40000 ALTER TABLE caja DISABLE KEYS */;
INSERT INTO caja VALUES (1,0,'Caja 0'),(2,1,'Caja 1');
/*!40000 ALTER TABLE caja ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table caja_ventas
--

DROP TABLE IF EXISTS caja_ventas;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE caja_ventas (
  idCajaVentas int(11) NOT NULL AUTO_INCREMENT,
  fechaApertura timestamp NOT NULL DEFAULT current_timestamp(),
  fechaCierre timestamp NULL DEFAULT NULL,
  observaciones varchar(150) DEFAULT NULL,
  saldoInicial float DEFAULT NULL,
  idcaja int(11) DEFAULT NULL,
  PRIMARY KEY (idCajaVentas),
  KEY idcaja (idcaja),
  CONSTRAINT caja_ventas_ibfk_1 FOREIGN KEY (idcaja) REFERENCES caja (idCaja)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table caja_ventas
--

LOCK TABLES caja_ventas WRITE;
/*!40000 ALTER TABLE caja_ventas DISABLE KEYS */;
INSERT INTO caja_ventas VALUES (5,'2020-10-26 02:08:47','2020-10-30 01:17:35','',1000,1),(6,'2020-10-30 02:46:01',NULL,'',1000,1);
/*!40000 ALTER TABLE caja_ventas ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table categorias
--

DROP TABLE IF EXISTS categorias;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE categorias (
  id_categoria int(11) NOT NULL AUTO_INCREMENT,
  id_usuario int(11) NOT NULL,
  nombreCategoria varchar(150) DEFAULT NULL,
  fechaCaptura date DEFAULT NULL,
  PRIMARY KEY (id_categoria)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table categorias
--

LOCK TABLES categorias WRITE;
/*!40000 ALTER TABLE categorias DISABLE KEYS */;
INSERT INTO categorias VALUES (4,2,'Fideos','2020-10-26'),(5,2,'Bebidas','2020-10-26'),(6,3,'Canasta Basica','2020-10-26');
/*!40000 ALTER TABLE categorias ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table clientes
--

DROP TABLE IF EXISTS clientes;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE clientes (
  id_cliente int(11) NOT NULL AUTO_INCREMENT,
  id_usuario int(11) NOT NULL,
  nombre varchar(200) DEFAULT NULL,
  apellido varchar(200) DEFAULT NULL,
  direccion varchar(200) DEFAULT NULL,
  email varchar(200) DEFAULT NULL,
  telefono varchar(200) DEFAULT NULL,
  rfc varchar(200) DEFAULT NULL,
  puntos int(11) DEFAULT 0,
  PRIMARY KEY (id_cliente)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table clientes
--

LOCK TABLES clientes WRITE;
/*!40000 ALTER TABLE clientes DISABLE KEYS */;
INSERT INTO clientes VALUES (2,3,'Carlos ','Madris','Ciudad','carlitos@maill.com','76859430','12345678',3954),(3,3,'David','Revolorio','Ciudad','david@gmail.com','56748392','12345676',113);
/*!40000 ALTER TABLE clientes ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table cupones
--

DROP TABLE IF EXISTS cupones;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE cupones (
  idCupon int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(75) DEFAULT NULL,
  descripcion varchar(255) DEFAULT NULL,
  cantidad int(11) DEFAULT NULL,
  utilizados int(11) DEFAULT NULL,
  PRIMARY KEY (idCupon)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table cupones
--

LOCK TABLES cupones WRITE;
/*!40000 ALTER TABLE cupones DISABLE KEYS */;
INSERT INTO cupones VALUES (1,'CAMP001','CUPON POR 1 Menu Super Campero',998,0),(2,'DESC10','CUPON POR 10% descuento en Tiendas Max Distelsa',999,0),(3,'DESCINT10','CUPON POR 10% descuento en mercaderia Intelaf',999,0);
/*!40000 ALTER TABLE cupones ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table cupones_ventas
--

DROP TABLE IF EXISTS cupones_ventas;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE cupones_ventas (
  idCuponesVentas int(11) NOT NULL AUTO_INCREMENT,
  idCupon int(11) DEFAULT NULL,
  idVenta int(11) DEFAULT NULL,
  img varchar(255) DEFAULT NULL,
  PRIMARY KEY (idCuponesVentas),
  KEY idCupon (idCupon),
  CONSTRAINT cupones_ventas_ibfk_1 FOREIGN KEY (idCupon) REFERENCES cupones (idCupon)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table cupones_ventas
--

LOCK TABLES cupones_ventas WRITE;
/*!40000 ALTER TABLE cupones_ventas DISABLE KEYS */;
INSERT INTO cupones_ventas VALUES (1,1,16,''),(2,3,22,'codes/30-10-2020-05-51-37.png'),(3,2,23,'codes/30-10-2020-05-57-44.png');
/*!40000 ALTER TABLE cupones_ventas ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table imagenes
--

DROP TABLE IF EXISTS imagenes;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE imagenes (
  id_imagen int(11) NOT NULL AUTO_INCREMENT,
  id_categoria int(11) NOT NULL,
  nombre varchar(500) DEFAULT NULL,
  ruta varchar(500) DEFAULT NULL,
  fechaSubida date DEFAULT NULL,
  PRIMARY KEY (id_imagen)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table imagenes
--

LOCK TABLES imagenes WRITE;
/*!40000 ALTER TABLE imagenes DISABLE KEYS */;
INSERT INTO imagenes VALUES (2,5,'90e2866c-0fe7-498e-a5b9-7d5230ffee10.7e305c0c3853c5eac918626757ca8a22.jpeg','../../archivos/90e2866c-0fe7-498e-a5b9-7d5230ffee10.7e305c0c3853c5eac918626757ca8a22.jpeg','2020-10-26'),(3,6,'3001002-350x350.jpg','../../archivos/3001002-350x350.jpg','2020-10-26'),(4,4,'tubos.png','../../archivos/tubos.png','2020-10-30');
/*!40000 ALTER TABLE imagenes ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table usuarios
--

DROP TABLE IF EXISTS usuarios;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) DEFAULT NULL,
  apellido varchar(50) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  password tinytext DEFAULT NULL,
  fechaCaptura date DEFAULT NULL,
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table usuarios
--

LOCK TABLES usuarios WRITE;
/*!40000 ALTER TABLE usuarios DISABLE KEYS */;
INSERT INTO usuarios VALUES (3,'Admin','Admin','admin','d033e22ae348aeb5660fc2140aec35850c4da997','2020-10-26'),(4,'Roni','Quevedo','rquevedo','d033e22ae348aeb5660fc2140aec35850c4da997','2020-10-26');
/*!40000 ALTER TABLE usuarios ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table ventas
--

DROP TABLE IF EXISTS ventas;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE ventas (
  id_venta int(11) NOT NULL,
  id_cliente int(11) DEFAULT NULL,
  id_producto int(11) DEFAULT NULL,
  id_usuario int(11) DEFAULT NULL,
  precio float DEFAULT NULL,
  fechaCompra date DEFAULT NULL,
  tipo_pago varchar(2) DEFAULT NULL,
  idCajaVentas int(11) DEFAULT NULL,
  KEY idCajaVentas (idCajaVentas),
  CONSTRAINT ventas_ibfk_1 FOREIGN KEY (idCajaVentas) REFERENCES caja_ventas (idCajaVentas)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table ventas
--

LOCK TABLES ventas WRITE;
/*!40000 ALTER TABLE ventas DISABLE KEYS */;
INSERT INTO ventas VALUES (1,0,2,2,6,'2020-10-26','T',5),(1,0,2,2,6,'2020-10-26','T',5),(1,0,2,2,6,'2020-10-26','T',5),(2,0,2,2,6,'2020-10-26','E',5),(2,0,2,2,6,'2020-10-26','E',5),(2,0,2,2,6,'2020-10-26','E',5),(2,0,2,2,6,'2020-10-26','E',5),(2,0,2,2,6,'2020-10-26','E',5),(2,0,2,2,6,'2020-10-26','E',5),(2,0,2,2,6,'2020-10-26','E',5),(3,0,2,2,6,'2020-10-26','E',5),(3,0,2,2,6,'2020-10-26','E',5),(3,0,2,2,6,'2020-10-26','E',5),(3,0,2,2,6,'2020-10-26','E',5),(3,0,2,2,6,'2020-10-26','E',5),(4,3,2,3,6,'2020-10-26','E',5),(4,3,3,3,2,'2020-10-26','E',5),(5,2,2,3,0,'2020-10-30','E',6),(5,2,2,3,0,'2020-10-30','E',6),(5,2,2,3,0,'2020-10-30','E',6),(5,2,3,3,0,'2020-10-30','E',6),(5,2,3,3,0,'2020-10-30','E',6),(6,3,2,3,0,'2020-10-30','E',6),(6,3,2,3,0,'2020-10-30','E',6),(6,3,2,3,0,'2020-10-30','E',6),(6,3,2,3,0,'2020-10-30','E',6),(6,3,3,3,0,'2020-10-30','E',6),(6,3,3,3,0,'2020-10-30','E',6),(6,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(7,3,3,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(8,2,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(9,3,2,3,0,'2020-10-30','E',6),(10,0,2,3,0,'2020-10-30','E',6),(10,0,2,3,0,'2020-10-30','E',6),(10,0,2,3,0,'2020-10-30','E',6),(10,0,2,3,0,'2020-10-30','E',6),(10,0,2,3,0,'2020-10-30','E',6),(10,0,2,3,0,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(11,0,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(12,2,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(13,0,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(14,2,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(15,0,2,3,6,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(16,2,3,3,2,'2020-10-30','E',6),(17,0,2,3,6,'2020-10-30','E',6),(17,0,2,3,6,'2020-10-30','E',6),(17,0,2,3,6,'2020-10-30','E',6),(17,0,2,3,6,'2020-10-30','E',6),(18,2,4,3,2,'2020-10-30','E',6),(18,2,4,3,2,'2020-10-30','E',6),(18,2,4,3,2,'2020-10-30','E',6),(18,2,4,3,2,'2020-10-30','E',6),(18,2,4,3,2,'2020-10-30','E',6),(18,2,4,3,2,'2020-10-30','E',6),(19,3,4,3,2,'2020-10-30','E',6),(19,3,4,3,2,'2020-10-30','E',6),(19,3,4,3,2,'2020-10-30','E',6),(19,3,4,3,2,'2020-10-30','E',6),(19,3,4,3,2,'2020-10-30','E',6),(19,3,4,3,2,'2020-10-30','E',6),(20,2,2,3,6,'2020-10-30','T',6),(20,2,2,3,6,'2020-10-30','T',6),(21,3,2,3,6,'2020-10-30','E',6),(21,3,3,3,2,'2020-10-30','E',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,4,3,2,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,2,3,6,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(22,2,3,3,2,'2020-10-30','T',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,3,3,2,'2020-10-30','E',6),(23,2,4,3,2,'2020-10-30','E',6),(23,2,4,3,2,'2020-10-30','E',6),(23,2,4,3,2,'2020-10-30','E',6),(23,2,4,3,2,'2020-10-30','E',6),(23,2,4,3,2,'2020-10-30','E',6),(23,2,4,3,2,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6),(23,2,2,3,6,'2020-10-30','E',6);
/*!40000 ALTER TABLE ventas ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-29 23:09:57
