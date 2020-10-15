<?php 
	session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";
	$obj= new ventas();

	
	if(count($_SESSION['tablaComprasTemp'])==0){
		echo 0;
	}else{
		$result=$obj->crearVenta();
		if($result > 0){
			unset($_SESSION['tablaComprasTemp']);
			unset($_SESSION['caja']);
		}
		echo $result;
	}
 ?>