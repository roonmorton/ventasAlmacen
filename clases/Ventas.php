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

		$fecha = date('Y-m-d');
		$idventa = self::creaFolio();
		$datos = $_SESSION['tablaComprasTemp'];
		$idusuario = $_SESSION['iduser'];
		$r = 0;
		$rollback = array();

		for ($i = 0; $i < count($datos); $i++) {
			$d = explode("||", $datos[$i]);

			$sql = 'select cantidad from articulos where id_producto =' . $d[0];
			$sProducto = mysqli_query($conexion, $sql);
			$cantidad = mysqli_fetch_row($sProducto)[0];

			if ($cantidad > 0) {

				$sql = "INSERT into ventas (id_venta,
				id_cliente,
				id_producto,
				id_usuario,
				precio,
				fechaCompra,
				tipo_pago
				)
	values ('$idventa',
			'$d[5]',
			'$d[0]',
			'$idusuario',
			'$d[3]',
			'$fecha',
			'$d[6]')";
				$r = $r + $result = mysqli_query($conexion, $sql);

				$sql = 'UPDATE articulos set cantidad = (cantidad-1) where id_producto =' . $d[0];
				mysqli_query($conexion, $sql);
				array_push($rollback, $d[0]);
			} else {
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

		return $r;
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
		if($ver){
			return $ver[0] . " " . $ver[1];

		}else{
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
