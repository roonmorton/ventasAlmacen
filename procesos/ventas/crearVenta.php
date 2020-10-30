<?php 
	session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";
	$obj= new ventas();

	
	if(!isset($_SESSION['tablaComprasTemp']) || (isset($_SESSION['tablaComprasTemp'])  && count($_SESSION['tablaComprasTemp'])==0)){
		echo 0;
	}else{
		$result=$obj->crearVenta();
		if($result > 0){
			unset($_SESSION['tablaComprasTemp']);
			unset($_SESSION['caja']);
			unset($_SESSION['idCliente']);
		}
		echo $result;
	}
 ?>