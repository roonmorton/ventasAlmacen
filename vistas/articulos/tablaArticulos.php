<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();
$sql = "SELECT art.nombre,
					art.descripcion,
					art.cantidad,
					art.precio,
					img.ruta,
					cat.nombreCategoria,
					art.id_producto
		  from articulos as art 
		  inner join imagenes as img
		  on art.id_imagen=img.id_imagen
		  inner join categorias as cat
		  on art.id_categoria=cat.id_categoria";
$result = mysqli_query($conexion, $sql);

?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>IMAGEN</th>
			<th>NOMBRE</th>
			<th>DESCRIPCION</th>
			<th>CATEGORIA</th>
			<th>PRECIO</th>
			<th>CANTIDAD</th>
			<th>ACCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($ver = mysqli_fetch_row($result)) : ?>

			<tr>
				<th scope="row" style="vertical-align: middle;"><?php echo $ver[6] ?></th>
				<td style="vertical-align: middle;">
					<?php
					$imgVer = explode("/", $ver[4]);
					$imgruta = $imgVer[1] . "/" . $imgVer[2] . "/" . $imgVer[3];
					?>
					<img width="60" height="60" src="<?php echo $imgruta ?>">
				</td>
				<td style="vertical-align: middle;"><?php echo $ver[0]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[1]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[5]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[3]; ?></td>
				<td style="vertical-align: middle;"><?php echo $ver[2]; ?></td>
				<td style="vertical-align: middle;">
					<span data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-warning btn-xs" onclick="agregaDatosArticulo('<?php echo $ver[6] ?>')">
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
					<span class="btn btn-danger btn-xs" onclick="eliminaArticulo('<?php echo $ver[6] ?>')">
						<span class="glyphicon glyphicon-remove"></span>
					</span>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>