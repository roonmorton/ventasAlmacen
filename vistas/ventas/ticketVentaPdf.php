<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";
	include('../../phpqrcode/qrlib.php' ); 

	$objv= new ventas();


	$c=new conectar();
	$conexion= $c->conexion();	
	$idventa=$_GET['idventa'];

 $sql="SELECT ve.id_venta,
		ve.fechaCompra,
		ve.id_cliente,
		art.nombre,
        art.precio,
        art.descripcion
	from ventas  as ve 
	inner join articulos as art
	on ve.id_producto=art.id_producto
	and ve.id_venta='$idventa'";

$result=mysqli_query($conexion,$sql);

	$ver=mysqli_fetch_row($result);

	$folio=$ver[0];
	$fecha=$ver[1];
	$idcliente=$ver[2];

 ?>	

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte de venta</title>
 	<style type="text/css">
		
@page {
            margin-top: 0.3em;
            margin-left: 0.6em;
        }
    body{
    	/* font-size: xx-small; */
		font-size: 1.5em;
		
    }
	.ticket{
		width: 500px;
		margin: 1em auto;
	}
	.img-thumbnail{
		margin: 0 auto;
    display: block;
	}
	</style>

 </head>
 <body>
 		
<div class="ticket">
<p>Ingenieria en sistemas</p>
 		<p>
 			Fecha: <?php echo $fecha; ?>
 		</p>
 		<p>
 			Folio: <?php echo $folio ?>
 		</p>
 		<p>
 			cliente: <?php echo $objv->nombreCliente($idcliente); ?>
 		</p>
<table style="border-collapse: collapse; width:100%" border="1">
 			<tr>
 				<td>Nombre</td>
 				<td>Precio</td>
 			</tr>
 			<?php 
 				$sql="SELECT ve.id_venta,
							ve.fechaCompra,
							ve.id_cliente,
							art.nombre,
					        art.precio,
					        art.descripcion
						from ventas  as ve 
						inner join articulos as art
						on ve.id_producto=art.id_producto
						and ve.id_venta='$idventa'";

				$result=mysqli_query($conexion,$sql);
				$total=0;
				while($mostrar=mysqli_fetch_row($result)){

 			 ?>
 			<tr>
 				<td><?php echo "Q ".$mostrar[3]; ?></td>
 				<td><?php echo "Q ".$mostrar[4] ?></td>
 			</tr>
 			<?php
 				$total=$total + $mostrar[4];
 				} 
 			 ?>
 			 <tr>
			  <td>Total: </td>
 			 	<td><?php echo "Q ".$total ?></td>
 			 </tr>
 		</table>
		 <?php
    $codesDir = "C:\\xampp\\htdocs\\ventasAlmacen\\public\\codes\\";   
    $codeFile = date('d-m-Y-h-i-s').'.png';
    QRcode::png('hola', $codesDir.$codeFile,'H',10); 
    echo '<img class="img-thumbnail" src="'.'/ventasAlmacen/public/codes/'.$codeFile.'" />';
 			 ?>
		 
</div>
 		

 		
 </body>
 </html>
 