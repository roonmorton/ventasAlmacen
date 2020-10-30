<?php
session_start();
if (isset($_SESSION['usuario'])) {

?>






	<?php
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";
	include('../../phpqrcode/qrlib.php');

	$objv = new ventas();


	$c = new conectar();
	$conexion = $c->conexion();
	$idventa = $_GET['idventa'];

	$sql = "SELECT ve.id_venta,
		ve.fechaCompra,
		ve.id_cliente,
		art.nombre,
        art.precio,
        art.descripcion,
		cli.rfc,
		concat(cli.nombre, ' ' , cli.apellido),
		sum(art.puntos)
	from ventas  as ve 
	inner join articulos as art
	on ve.id_producto=art.id_producto and ve.id_venta='$idventa'
	left join clientes as cli
    on cli.id_cliente = ve.id_cliente group by ve.id_venta";

	$result = mysqli_query($conexion, $sql);

	$ver = mysqli_fetch_row($result);

	$folio = $ver[0];
	$fecha = $ver[1];
	$idcliente = $ver[2];
	$nombre = $ver[7];
	$nit = $ver[6];
	$puntos = $ver[8];

	?>

	<!DOCTYPE html>
	<html>

	<head>
		<title>Reporte de venta</title>
		<?php require_once "../menu.php"; ?>
		<style type="text/css">
			@page {
				margin-top: 0.3em;
				margin-left: 0.6em;
			}

			body {
				/* font-size: xx-small; */
				font-size: 1.5em;

			}

			.ticket {
				width: 500px;
				margin: 1em auto;
				border: solid 1px #e9e5e5;
				padding: 10px;
			}

			.img-thumbnail {
				margin: 0 auto;
				display: block;
			}
		</style>

	</head>

	<body>

		<div class="ticket">
			<p style="text-align: center;"><strong>Ingenieria en sistemas</strong></p>
			<ul style="list-style: none;">
				<li><strong>Fecha:</strong> <?php echo $fecha; ?></li>
				<li><strong>No. Fac:</strong> <?php echo $folio ?></li>
				<li><strong>Cliente:</strong> <?php echo $nombre == null ? 'C/F' : $nombre; /* $objv->nombreCliente($idcliente); */ ?></li>
				<li><strong>NIT:</strong> <?php echo $nit == null ? 'C/F' : $nit; /* $objv->nombreCliente($idcliente); */ ?> </li>
			</ul>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">NOMBRE</th>
						<th scope="col">PRECIO</th>
						<th scope="col">CANTIDAD</th>
						<th scope="col">TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT ve.id_venta,
				ve.fechaCompra,
				ve.id_cliente,
				art.nombre,
				art.precio,
				art.descripcion,
				sum(1),
				(@row_number:=@row_number + 1) AS num
			from (SELECT @row_number:=0) AS t, ventas  as ve 
			inner join articulos as art
			on ve.id_producto=art.id_producto
			and ve.id_venta=$idventa 
			group by art.id_producto;";
					$result = mysqli_query($conexion, $sql);
					$total = 0;
					while ($mostrar = mysqli_fetch_row($result)) {
					?>
						<tr>
							<th scope="row"><?php echo $mostrar[7]; ?></th>
							<td><?php echo $mostrar[3]; ?></td>
							<td><?php echo 'Q. ' . $mostrar[4]; ?></td>
							<td><?php echo  $mostrar[6]; ?></td>
							<td><?php echo 'Q. ' .  $mostrar[6] * $mostrar[4]; ?></td>
						</tr>
					<?php
						$total = $total + ($mostrar[6] * $mostrar[4]);
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" style="text-align: right;"><strong>Total</strong></td>
						<td> <strong><?php echo "Q ." . $total ?> </strong> </td>
					</tr>
				</tfoot>
			</table>
			<br>
			<?php
			$sql = "select cv.idCupon, cv.img, c.nombre, c.descripcion, cv.idCuponesVentas   from cupones_ventas  as cv
			inner join cupones as c on 
			c.idCupon = cv.idCupon 
			AND cv.idVenta = $folio";
			$sCupon = mysqli_query($conexion, $sql);
			$cupon = mysqli_fetch_row($sCupon);
			if ($cupon != null) {
				$img = $cupon[1];
				if ($img == null || $img == '') {
					$text = $cupon[2] . ' || ' . $cupon[3];
					if ($puntos > 0) {
						$text = $text . " || Ganaste $puntos puntos";
					}
					$fileName = "codes/" . date('d-m-Y-h-i-s') . '.png';
					QRcode::png($text, $fileName, 'H', 10);
					$sql = "update cupones_ventas set img = '$fileName' where idCuponesVentas = $cupon[4]";
					mysqli_query($conexion, $sql);
					echo '<img class="img-thumbnail" src="' . $fileName . '"  width="360"/>';
				} else {
					echo '<img class="img-thumbnail" src="' . $img . '" width="360" />';
				}
			} else {
				$text = '';
				if ($puntos > 0) {
					$text = "";
					$text = "Ganaste " . strval($puntos) . " puntos";
					$fileName = "codes/" . date('d-m-Y-h-i-s') . '.png';
					QRcode::png($text, $fileName, 'H', 10);
					echo '<img class="img-thumbnail" src="' . $fileName . '"  width="360"/>';
				}
			}
			/* $codesDir = "";
			$codeFile = date('d-m-Y-h-i-s') . '.png';
			QRcode::png('hola', $codesDir . $codeFile, 'H', 10);
			echo '<img class="img-thumbnail" src="' . $codesDir . $codeFile . '" />'; */
			?>

		</div>



	</body>

	</html>

<?php
} else {
?>
	<?php
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";
	include('../../phpqrcode/qrlib.php');

	$objv = new ventas();


	$c = new conectar();
	$conexion = $c->conexion();
	$idventa = $_GET['idventa'];

	$sql = "SELECT ve.id_venta,
	ve.fechaCompra,
	ve.id_cliente,
	art.nombre,
	art.precio,
	art.descripcion,
	cli.rfc,
	concat(cli.nombre, ' ' , cli.apellido),
	sum(art.puntos)
from ventas  as ve 
inner join articulos as art
on ve.id_producto=art.id_producto and ve.id_venta='$idventa'
left join clientes as cli
on cli.id_cliente = ve.id_cliente group by ve.id_venta";

	$result = mysqli_query($conexion, $sql);

	$ver = mysqli_fetch_row($result);

	$folio = $ver[0];
	$fecha = $ver[1];
	$idcliente = $ver[2];
	$nombre = $ver[7];
	$nit = $ver[6];
	$puntos = $ver[8];
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

			body {
				/* font-size: xx-small; */
				font-size: 1.5em;

			}

			.ticket {
				width: 500px;
				margin: 1em auto;
				border: solid 1px #e9e5e5;
    padding: 10px;
			}

			.img-thumbnail {
				margin: 0 auto;
				display: block;
			}
		</style>

	</head>

	<body>

		<div class="ticket">
			<p style="text-align: center;"><strong>Ingenieria en sistemas</strong></p>
			<ul style="list-style: none;">
				<li><strong>Fecha:</strong> <?php echo $fecha; ?></li>
				<li><strong>No. Fac:</strong> <?php echo $folio ?></li>
				<li><strong>Cliente:</strong> <?php echo $nombre == null ? 'C/F' : $nombre; /* $objv->nombreCliente($idcliente); */ ?></li>
				<li><strong>NIT:</strong> <?php echo $nit == null ? 'C/F' : $nit; /* $objv->nombreCliente($idcliente); */ ?> </li>
			</ul>
			<table class="table table-bordered" border="2">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">NOMBRE</th>
						<th scope="col">PRECIO</th>
						<th scope="col">CANTIDAD</th>
						<th scope="col">TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT ve.id_venta,
					ve.fechaCompra,
					ve.id_cliente,
					art.nombre,
					art.precio,
					art.descripcion,
					sum(1),
					(@row_number:=@row_number + 1) AS num
				from (SELECT @row_number:=0) AS t, ventas  as ve 
				inner join articulos as art
				on ve.id_producto=art.id_producto
				and ve.id_venta=$idventa 
				group by art.id_producto;";
					$result = mysqli_query($conexion, $sql);
					$total = 0;
					while ($mostrar = mysqli_fetch_row($result)) {
					?>
						<tr>
							<th scope="row"><?php echo $mostrar[7]; ?></th>
							<td><?php echo $mostrar[3]; ?></td>
							<td><?php echo 'Q. ' . $mostrar[4]; ?></td>
							<td><?php echo  $mostrar[6]; ?></td>
							<td><?php echo 'Q. ' .  $mostrar[6] * $mostrar[4]; ?></td>
						</tr>
					<?php
						$total = $total + ($mostrar[6] * $mostrar[4]);
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" style="text-align: right;"><strong>Total</strong></td>
						<td> <strong><?php echo "Q ." . $total ?> </strong> </td>
					</tr>
				</tfoot>
			</table>
			<br>
			<?php

			$sql = "select cv.idCupon, cv.img, c.nombre, c.descripcion, cv.idCuponesVentas   from cupones_ventas  as cv
inner join cupones as c on 
c.idCupon = cv.idCupon 
AND cv.idVenta = $folio";
			$sCupon = mysqli_query($conexion, $sql);
			$cupon = mysqli_fetch_row($sCupon);
			if ($cupon != null) {
				$img = $cupon[1];
				if ($img == null || $img == '') {
					$text = $cupon[2] . ' || ' . $cupon[3];
					if ($puntos > 0) {
						$text += " || Ganaste $puntos puntos";
					}
					$fileName = "codes/" . date('d-m-Y-h-i-s') . '.png';
					echo $fileName;
					QRcode::png($text, $fileName, 'H', 10);
					$sql = "update cupones_ventas set img = '$fileName' where idCuponesVentas = $cupon[4]";
					mysqli_query($conexion, $sql);
					echo '<img class="img-thumbnail" src="' . $fileName . '"  width="360"/>';
				} else {
					echo '<img class="img-thumbnail" src="' . $img . '" width="360" />';
				}
			} else {
				$text = '';
				if ($puntos > 0) {
					$text += "Ganaste $puntos puntos";
					$fileName = "codes/" . date('d-m-Y-h-i-s') . '.png';
					echo $fileName;
					QRcode::png($text, $fileName, 'H', 10);
					echo '<img class="img-thumbnail" src="' . $fileName . '"  width="360"/>';
				}
			}
			/* $codesDir = "";
			$codeFile = date('d-m-Y-h-i-s') . '.png';
			QRcode::png('hola', $codesDir . $codeFile, 'H', 10);
			echo '<img class="img-thumbnail" src="' . $codesDir . $codeFile . '" />'; */
			?>

		</div>



	</body>

	</html>

<?php
}
?>