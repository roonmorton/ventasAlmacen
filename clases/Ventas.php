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
		$conexion = $c->conexion();

		$caja = $_SESSION['caja'];
		$sql = "select idCajaVentas from caja 
		inner join caja_ventas 
		ON caja.idCaja = caja_ventas.idCaja
		WHERE caja_ventas.fechaCierre <=> null and caja.idCaja = $caja";

		$resul = mysqli_query($conexion, $sql);
		$id = mysqli_fetch_row($resul);
		$total = 0;
		$puntos = 0;
		$idCliente = 0;
		if ($id == "" or $id == null or $id == 0) {
			return -2;
		} else {
			$caja = $id[0];
			$fecha = date('Y-m-d');
			$idventa = self::creaFolio();
			$datos = $_SESSION['tablaComprasTemp'];
			$idusuario = $_SESSION['iduser'];
			$r = 0;
			$rollback = array();

			for ($i = 0; $i < count($datos); $i++) {
				$d = explode("||", $datos[$i]);

				$sql = 'select cantidad, precio, puntos from articulos where id_producto =' . $d[0];
				$sProducto = mysqli_query($conexion, $sql);
				$producto = mysqli_fetch_row($sProducto);
				$cantidad = $producto[0];
				$precio = $producto[1];
				$p = $producto[2];
				$idCliente = $d[5];

				if ($cantidad > 0) {

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

					$sql = 'UPDATE articulos set cantidad = (cantidad-1) where id_producto =' . $d[0];
					mysqli_query($conexion, $sql);
					array_push($rollback, $d[0]);
					$total = $total + (int)$precio;
					$puntos = $puntos + (int)$p;

				} else {
					$total = 0;
					$puntos = 0;
					for ($ii = 0; $ii < count($rollback); $ii++) {
						$sql = 'UPDATE articulos set cantidad = (cantidad+1) where id_producto =' . $rollback[$ii];
						mysqli_query($conexion, $sql);
					}
					$sql = 'delete from ventas where id_venta = ' . $idventa;
					$sProducto = mysqli_query($conexion, $sql);
					$r = -1;
					break;
				}
			}
			if($puntos > 0 && $idCliente != 0 ){
				$sql = "update clientes set puntos = puntos + $puntos where id_cliente = $idCliente";
				$sCupones = mysqli_query($conexion, $sql);	
			}

			if ($total > 50) {
				$sql = "SELECT count(1) FROM cupones";
				$sCupones = mysqli_query($conexion, $sql);
				$cantidad = mysqli_fetch_row($sCupones)[0];
				$cuponRand =  rand(1, $cantidad);
				$sql = "select idCupon, cantidad from cupones where idCupon = $cuponRand";

				$sCupon = mysqli_query($conexion, $sql);
				$cupon = mysqli_fetch_row($sCupon);
				if ($cupon != null && $cupon[1] > 0) {
					$sql = "update cupones set cantidad = (cantidad-1) where idCupon = $cupon[0]";
					mysqli_query($conexion, $sql);
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

		$sql = "SELECT id_venta from ventas group by id_venta desc";

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
