<?php

class ventas
{
	public function obtenDatosProducto($idproducto)
	{
		$c = new conectar();
		$conexion = $c->conexion();

		$sql = "SELECT art.nombre,
		art.descripcion,
		art.cantidad,
		img.ruta,
		art.precio
		from articulos as art 
		inner join imagenes as img
		on art.id_imagen=img.id_imagen 
		and art.id_producto='$idproducto'";
		$result = mysqli_query($conexion, $sql);

		$ver = mysqli_fetch_row($result);

		$d = explode('/', $ver[3]);

		$img = $d[1] . '/' . $d[2] . '/' . $d[3];

		$data = array(
			'nombre' => $ver[0],
			'descripcion' => $ver[1],
			'cantidad' => $ver[2],
			'ruta' => $img,
			'precio' => $ver[4]
		);
		return $data;
	}

	public function crearVenta()
	{
		
		$c = new conectar();
		// Obtiene la conexion abierta 
		$conexion = $c->conexion();

		//Obtiene id caja de sesion
		$caja = $_SESSION['caja'];
		// consulta para obtener caja si esta abierta 
		$sql = "select idCajaVentas from caja 
		inner join caja_ventas 
		ON caja.idCaja = caja_ventas.idCaja
		WHERE caja_ventas.fechaCierre <=> null and caja.idCaja = $caja";

		$resul = mysqli_query($conexion, $sql);
		$id = mysqli_fetch_row($resul);
		$total = 0;
		$puntos = 0;
		$idCliente = 0;
		// Si no esta la caja abierta retorna -2
		if ($id == "" or $id == null or $id == 0) {
			return -2;
		} else {
			$caja = $id[0];
			$fecha = date('Y-m-d');
			// se crea el numero de venta 
			$idventa = self::creaFolio();
			$datos = $_SESSION['tablaComprasTemp'];
			$idusuario = $_SESSION['iduser'];
			$r = 0;
			// para guardar productos, si se hace una venta y no hay stock de un producto se revierte los productos guardados el rollback
			$rollback = array();

			for ($i = 0; $i < count($datos); $i++) {
				$d = explode("||", $datos[$i]);
				// selecciona producto para validar su stock disponible 
				$sql = 'select cantidad, precio, puntos from articulos where id_producto =' . $d[0];
				$sProducto = mysqli_query($conexion, $sql);
				$producto = mysqli_fetch_row($sProducto);
				$cantidad = $producto[0];
				$precio = $producto[1];
				$p = $producto[2];
				$idCliente = $d[5];

				// SI hay stock
				if ($cantidad > 0) {
						// crea venta por cada producto 
					$sql = "INSERT into ventas (id_venta,
				id_cliente,
				id_producto,
				id_usuario,
				precio,
				fechaCompra,
				tipo_pago,
				idCajaVentas
				)
	values ('$idventa',
			'$idCliente',
			'$d[0]',
			'$idusuario',
			'$precio',
			'$fecha',
			'$d[6]',
			$caja)";

					$r = $r + $result = mysqli_query($conexion, $sql);

					// reabaja del inventario
					$sql = 'UPDATE articulos set cantidad = (cantidad-1) where id_producto =' . $d[0];
					mysqli_query($conexion, $sql);
					array_push($rollback, $d[0]);
					$total = $total + (int)$precio;
					$puntos = $puntos + (int)$p;

				} else { 
					 // Si no hay stock 
					$total = 0;
					$puntos = 0;
					for ($ii = 0; $ii < count($rollback); $ii++) {
						// actualiza producto para devolverle el stock
						$sql = 'UPDATE articulos set cantidad = (cantidad+1) where id_producto =' . $rollback[$ii];
						mysqli_query($conexion, $sql);
					}
					// borra la venta 
					$sql = 'delete from ventas where id_venta = ' . $idventa;
					$sProducto = mysqli_query($conexion, $sql);
					$r = -1;
					break;
				}
			}
			// validacion de puntos si tiene puntos 
			if($puntos > 0 && $idCliente != 0 ){
				// actualiza puntos acumulados del cliente 
				$sql = "update clientes set puntos = puntos + $puntos where id_cliente = $idCliente";
				$sCupones = mysqli_query($conexion, $sql);	
			}

			// si el total de la venta es mayor a 50 se genera un cupon 
			if ($total > 50) {
				// cuenta cuantos cupones hay 
				$sql = "SELECT count(1) FROM cupones";
				$sCupones = mysqli_query($conexion, $sql);
				$cantidad = mysqli_fetch_row($sCupones)[0];
				// genera un id de cupon en rango 1 hasta un maximo de cupones en la tabla 
				$cuponRand =  rand(1, $cantidad);
				// consulta si el cupon tiene existencia 
				$sql = "select idCupon, cantidad from cupones where idCupon = $cuponRand and cantidad > 0";

				$sCupon = mysqli_query($conexion, $sql);
				$cupon = mysqli_fetch_row($sCupon);
				// si el cupon es valido 
				if ($cupon != null && $cupon[1] > 0) {
					// actualiza cupones de se entrego un cupon 
					$sql = "update cupones set cantidad = (cantidad-1) where idCupon = $cupon[0]";
					mysqli_query($conexion, $sql);
					// inserta el cupon asignado a la venta 
					$sql = "INSERT INTO CUPONES_VENTAS(idCupon, idVenta) values($cupon[0],$idventa)";
					mysqli_query($conexion, $sql);
				}
			}
			return $r;
		}
	}

	public function creaFolio()
	{
		$c = new conectar();
		$conexion = $c->conexion();

		$sql = "SELECT count(1) from ventas";

		$resul = mysqli_query($conexion, $sql);
		$id = mysqli_fetch_row($resul)[0];

		if ($id == "" or $id == null or $id == 0) {
			return 1;
		} else {
			return $id + 1;
		}
	}

	public function nombreCliente($idCliente)
	{
		$c = new conectar();
		$conexion = $c->conexion();

		$sql = "SELECT apellido,nombre 
			from clientes 
			where id_cliente='$idCliente'";
		$result = mysqli_query($conexion, $sql);

		$ver = mysqli_fetch_row($result);
		if ($ver) {
			return $ver[0] . " " . $ver[1];
		} else {
			return " ";
		}
	}

	public function obtenerTotal($idventa)
	{
		$c = new conectar();
		$conexion = $c->conexion();

		$sql = "SELECT precio 
				from ventas 
				where id_venta='$idventa'";
		$result = mysqli_query($conexion, $sql);

		$total = 0;

		while ($ver = mysqli_fetch_row($result)) {
			$total = $total + $ver[0];
		}

		return $total;
	}
}
