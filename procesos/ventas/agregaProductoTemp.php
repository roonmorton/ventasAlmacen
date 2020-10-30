<?php 
	session_start();
	require_once "../../clases/Conexion.php";

	$c= new conectar();
	$conexion=$c->conexion();

	if(isset($_SESSION['idCliente'])){
		/* $_SESSION['idCliente'] = $_POST['clienteVenta']; */
		$idcliente = $_SESSION['idCliente'] ;
	}else{
		$idcliente = $_POST['clienteVenta'];
		$_SESSION['idCliente'] =$idcliente;
	}
	/* $idcliente=$_POST['clienteVenta']; */
	$idproducto=$_POST['productoVenta'];
	$descripcion=$_POST['descripcionV'];
	$cantidad=$_POST['cantidadV'];
	$precio=$_POST['precioV'];
	$tipoPago = $_POST['formaPago'];

	$sql="SELECT nombre,apellido 
			from clientes 
			where id_cliente='$idcliente'";
	$result=mysqli_query($conexion,$sql);

	$c=mysqli_fetch_row($result);

	$ncliente=$c[1]." ".$c[0];

	$sql="SELECT nombre 
			from articulos 
			where id_producto='$idproducto'";
	$result=mysqli_query($conexion,$sql);

	$nombreproducto=mysqli_fetch_row($result)[0];

	$articulo=$idproducto."||".
				$nombreproducto."||".
				$descripcion."||".
				$precio."||".
				$ncliente."||".
				$idcliente."||". 
				$tipoPago;

	if(!isset($_SESSION['caja'])){
		$_SESSION['caja'] = $_POST['idCaja'];
	}
	
	print_r($_SESSION['caja']);
	$_SESSION['tablaComprasTemp'][]=$articulo;

 ?>