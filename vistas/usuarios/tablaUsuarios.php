<?php 
	
	require_once "../../clases/Conexion.php";
	$c= new conectar();
	$conexion=$c->conexion();

	$sql="SELECT id_usuario,
					nombre,
					apellido,
					email
			from usuarios";
	$result=mysqli_query($conexion,$sql);

 ?>

<table class="table table-hover">
	<thead>
		<tr>
		<th>NOMBRE</th>
		<th>APELLIDO</th>
		<th>USUARIO</th>
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
				<td style="vertical-align: middle;">
					<span data-toggle="modal" data-target="#actualizaUsuarioModal" class="btn btn-warning btn-xs" onclick="agregaDatosUsuario('<?php echo $ver[0] ?>')">
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
					<span class="btn btn-danger btn-xs" onclick="eliminarUsuario('<?php echo $ver[0] ?>')">
						<span class="glyphicon glyphicon-remove"></span>
					</span>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>