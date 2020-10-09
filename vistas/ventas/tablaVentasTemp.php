<?php

session_start();
//print_r($_SESSION['tablaComprasTemp']);
?>

<!-- <h4>Productos</h4> -->
<!-- <h4><strong><div id="nombreclienteVenta"></div></strong></h4> -->

<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>NOMBRE</th>
			<th>DESCRIPCION</th>
			<th style="text-align: center;">PRECIO</th>
			<th style="text-align: center;">CANTIDAD</th>
			<th style="text-align: center;">QUITAR</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$c = 0;
		$total = 0; //esta variable tendra el total de la compra en dinero
		$cliente = ""; //en esta se guarda el nombre del cliente
		if (isset($_SESSION['tablaComprasTemp'])) :
			$i = 0;
			foreach (@$_SESSION['tablaComprasTemp'] as $key) {

				$d = explode("||", @$key);
				$c++;
		?>
				<tr>
					<th scope="row"><?php echo $c ?></th>
					<td><?php echo $d[1] ?></td>
					<td><?php echo $d[2] ?></td>
					<td style="text-align: center;"><?php echo 'Q. '. $d[3] ?></td>
					<td style="text-align: center;"><?php echo 1; ?></td>
					<td style="text-align: center;">
						<span class="btn btn-danger btn-xs" onclick="quitarP('<?php echo $i; ?>')">
							<span class="glyphicon glyphicon-remove"></span>
						</span>
					</td>
				</tr>
		<?php
				$total = $total + $d[3];
				$i++;
				$cliente = $d[4];
			}
		endif;
		?>
		<tr>
			<td colspan="4" style="text-align:right;">Total de Ventas</td>
			<td style="text-align: center;">
				<strong><?php echo "Q" . $total; ?></strong>
			</td>
			<td></td>
		</tr>

	</tbody>
</table>



<script type="text/javascript">
	$(document).ready(function() {
		nombre = "<?php echo @$cliente ?>";
		$('#nombreclienteVenta').text("Nombre de cliente: " + nombre);
	});
</script>