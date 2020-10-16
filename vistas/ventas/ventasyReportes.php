<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

$c = new conectar();
$conexion = $c->conexion();

$obj = new ventas();

$sql = "SELECT id_venta,
				fechaCompra,
				id_cliente, count(1), sum(precio) , tipo_pago
			from ventas group by id_venta order by id_venta DESC";
$result = mysqli_query($conexion, $sql);
?>
<div class="container">
	<hr>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4>Reporte de ventas</h4>

		</div>
		<div class="panel-body">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>NO</th>
						<th>FECHA</th>
						<th>CLIENTE</th>
						<th>TOTAL</th>
						<th>TIPO PAGO</th>
						<th>PRODUCTOS</th>
						<th>Ticket</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($ver = mysqli_fetch_row($result)) : ?>

						<tr>
							<td><?php echo $ver[0]; ?></td>
							<td><?php echo $ver[1] ?></td>
							<td>
								<?php
								if ($obj->nombreCliente($ver[2]) == " ") {
									echo "C/F";
								} else {
									echo $obj->nombreCliente($ver[2]);
								}
								?>
							</td>
							<td>
								<?php
								echo  'Q. ' . $ver[4]
								?>
							</td>
							<td>
								<?php
								echo  $ver[5] == 'E' ? 'EFECTIVO' : ($ver[5] == 'T' ? 'TARJETA' : '');
								?>
							</td>
							<td>
								<?php
								echo  $ver[3]
								?>
							</td>
							<td>
								<a href="./ventas/ticketVentaPdf.php?idventa=<?php echo $ver[0] ?>" class="btn btn-info btn-sm">
									Comprobante <span class="glyphicon glyphicon-list-alt"></span>
								</a>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
	<br>

</div>