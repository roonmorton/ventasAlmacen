<?php
require_once "../../clases/Conexion.php";

$obj = new conectar();
$conexion = $obj->conexion();

$sql = "SELECT id_cliente, 
				nombre,
				apellido,
				direccion,
				email,
				telefono,
				rfc,
				puntos 
		from clientes";
$result = mysqli_query($conexion, $sql);
?>



<table class="table table-hover">
	<thead>
		<tr>
		<th>CODIGO</th>

			<th>NOMBRE</th>
			<th>APELLIDO</td>
			<th>DIRECCION</th>
			<th>CORREO</th>
			<th>TELEFONO</th>
			<th>NIT</th>
			<th>PUNTOS ACUM</th>

			<th>ACCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($ver = mysqli_fetch_row($result)) : ?>

			<tr>
				<th scope="row" style="vertical-align: middle;"><?php echo $ver[0] ?></th>

				<td style="vertical-align: middle;"><?php echo $ver[1]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[2]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[3]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[4]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[5]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[6]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[7]; ?></td>

				<td style="vertical-align: middle;">
					<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#abremodalClientesUpdate" onclick="agregaDatosCliente('<?php echo $ver[0]; ?>')">
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
					<span class="btn btn-danger btn-xs" onclick="eliminarCliente('<?php echo $ver[0]; ?>')">
						<span class="glyphicon glyphicon-remove"></span>
					</span>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>