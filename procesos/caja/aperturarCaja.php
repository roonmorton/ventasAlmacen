<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Caja.php";

	$datos=array(
		$_POST['idCaja'],
        $_POST['monto'],
		$_POST['descripcion']
			);
	$obj= new Caja();
	echo $obj->aperturarCaja($datos);

 ?>