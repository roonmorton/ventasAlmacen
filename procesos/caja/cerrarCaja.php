<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Caja.php";

	$id=$_POST['idCaja'];
	$obj= new Caja();
	echo $obj->cerrar($id);

 ?>