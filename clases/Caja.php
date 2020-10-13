


<?php

class Caja
{

	public function aperturarCaja($datos)
	{
		$c = new conectar();
		$conexion = $c->conexion();

		$sql = "select count(*) from caja 
			inner join caja_ventas 
			ON caja.idCaja = caja_ventas.idCaja
			WHERE caja_ventas.fechaCierre <=> null and caja.idCaja = $datos[0]";

		$resul = mysqli_query($conexion, $sql);
		$id = mysqli_fetch_row($resul)[0];

		if ($id == "" or $id == null or $id == 0) {
			$sql = "insert into caja_ventas(fechaApertura, observaciones, saldoInicial, idCaja)
			values (now(), '$datos[2]', $datos[1], $datos[0])";
			if (mysqli_query($conexion, $sql)) {
				return 0;
			} else {
				return 2;
			}
		} else {
			return 1;
		}
	}


	public function cerrar($idCaja)
	{
		$c = new conectar();
		$conexion = $c->conexion();
		$sql = "update caja_ventas set fechaCierre=now() where idCaja = $idCaja";
		return mysqli_query($conexion, $sql);
	}
}

?>