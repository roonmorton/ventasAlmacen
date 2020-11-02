drop database ventas;
CREATE DATABASE  IF NOT EXISTS ventas;
USE ventas;


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



CREATE TABLE caja (
  idCaja int(11) NOT NULL AUTO_INCREMENT,
  num int(11) DEFAULT NULL,
  descripcion varchar(75) DEFAULT NULL,
  PRIMARY KEY (idCaja)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;


INSERT INTO caja VALUES (1,0,'Caja 0'),(2,1,'Caja 1');



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


CREATE TABLE categorias (
  id_categoria int(11) NOT NULL AUTO_INCREMENT,
  id_usuario int(11) NOT NULL,
  nombreCategoria varchar(150) DEFAULT NULL,
  fechaCaptura date DEFAULT NULL,
  PRIMARY KEY (id_categoria)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;


INSERT INTO categorias VALUES (4,2,'Fideos','2020-10-26'),(5,2,'Bebidas','2020-10-26'),(6,3,'Canasta Basica','2020-10-26');


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





CREATE TABLE cupones (
  idCupon int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(75) DEFAULT NULL,
  descripcion varchar(255) DEFAULT NULL,
  cantidad int(11) DEFAULT NULL,
  utilizados int(11) DEFAULT NULL,
  PRIMARY KEY (idCupon)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;


INSERT INTO cupones VALUES (1,'CAMP001','CUPON POR 1 Menu Super Campero',998,0),(2,'DESC10','CUPON POR 10% descuento en Tiendas Max Distelsa',999,0),(3,'DESCINT10','CUPON POR 10% descuento en mercaderia Intelaf',999,0);


CREATE TABLE cupones_ventas (
  idCuponesVentas int(11) NOT NULL AUTO_INCREMENT,
  idCupon int(11) DEFAULT NULL,
  idVenta int(11) DEFAULT NULL,
  img varchar(255) DEFAULT NULL,
  PRIMARY KEY (idCuponesVentas),
  KEY idCupon (idCupon),
  CONSTRAINT cupones_ventas_ibfk_1 FOREIGN KEY (idCupon) REFERENCES cupones (idCupon)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;


CREATE TABLE imagenes (
  id_imagen int(11) NOT NULL AUTO_INCREMENT,
  id_categoria int(11) NOT NULL,
  nombre varchar(500) DEFAULT NULL,
  ruta varchar(500) DEFAULT NULL,
  fechaSubida date DEFAULT NULL,
  PRIMARY KEY (id_imagen)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;


CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) DEFAULT NULL,
  apellido varchar(50) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  password tinytext DEFAULT NULL,
  fechaCaptura date DEFAULT NULL,
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;


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

