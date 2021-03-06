<?php
session_start();
if (isset($_SESSION['usuario'])) {

?>


	<!DOCTYPE html>
	<html>

	<head>
		<title>articulos</title>
		<?php require_once "menu.php"; ?>
		<?php require_once "../clases/Conexion.php";
		$c = new conectar();
		$conexion = $c->conexion();
		$sql = "SELECT id_categoria,nombreCategoria
		from categorias";
		$result = mysqli_query($conexion, $sql);
		?>
	</head>

	<body>
		<div class="container">
			<h3>Articulos</h3>
			<hr>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Agregar</h3>
				</div>
				<div class="panel-body">
					<form id="frmArticulos" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="input-group" style="width: 100%;">
									<label>Nombre</label>
									<input type="text" class="form-control input-sm" id="nombre" name="nombre" autofocus>
								</div>
							</div>
							<div class="col-sm-6">
								<label>Categoria</label>
								<select class="form-control input-sm" id="categoriaSelect" name="categoriaSelect">
									<option value="A">Selecciona Categoria</option>
									<?php while ($ver = mysqli_fetch_row($result)) : ?>
										<option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<label>Cantidad</label>
								<input type="text" class="form-control input-sm" id="cantidad" name="cantidad">
							</div>
							<div class="col-sm-6">
								<label>Precio</label>
								<div class="input-group">
									<span class="input-group-addon">Q.</span>
									<input type="text" class="form-control input-sm" id="precio" name="precio">
								</div>
							</div>
						</div>
						<label>Puntos</label>
						<div class="input-group">
							<span class="input-group-addon">P</span>
							<input type="text" class="form-control input-sm" id="puntos" name="puntos">
						</div>
						<label>Descripcion</label><textarea class="form-control input-sm" id="descripcion" name="descripcion" rows="3"></textarea>
						<label>Imagen</label>
						<input type="file" id="imagen" name="imagen">
						<p></p>
						<span id="btnAgregaArticulo" class="btn btn-primary">Agregar</span>
					</form>
				</div>
			</div>
			<br>
			<div class="panel  panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Listado</h3>
				</div>
				<div class="panel-body">
					<div id="tablaArticulosLoad"></div>
				</div>
			</div>
		</div>


		<!-- Button trigger modal -->

		<!-- Modal -->
		<div class="modal fade" id="abremodalUpdateArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Actualiza Articulo</h4>
					</div>
					<div class="modal-body">
						<form id="frmArticulosU" enctype="multipart/form-data">
							<input type="text" id="idArticulo" hidden="" name="idArticulo">
							<label>Categoria</label>
							<select class="form-control input-sm" id="categoriaSelectU" name="categoriaSelectU">
								<option value="A">Selecciona Categoria</option>
								<?php
								$sql = "SELECT id_categoria,nombreCategoria
								from categorias";
								$result = mysqli_query($conexion, $sql);
								?>
								<?php while ($ver = mysqli_fetch_row($result)) : ?>
									<option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
								<?php endwhile; ?>
							</select>
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
							<label>Descripcion</label>
							<input type="text" class="form-control input-sm" id="descripcionU" name="descripcionU">
							<label>Cantidad</label>
							<input type="text" class="form-control input-sm" id="cantidadU" name="cantidadU">
							<label>Precio</label>
							<input type="text" class="form-control input-sm" id="precioU" name="precioU">
							<label>Puntos</label>

							<div class="input-group">

								<span class="input-group-addon">P</span>
								<input type="text" class="form-control input-sm" id="puntosU" name="puntosU">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnActualizaarticulo" type="button" class="btn btn-warning" data-dismiss="modal">Actualizar</button>

					</div>
				</div>
			</div>
		</div>

	</body>

	</html>

	<script type="text/javascript">
		function agregaDatosArticulo(idarticulo) {
			$.ajax({
				type: "POST",
				data: "idart=" + idarticulo,
				url: "../procesos/articulos/obtenDatosArticulo.php",
				success: function(r) {

					dato = jQuery.parseJSON(r);
					$('#idArticulo').val(dato['id_producto']);
					$('#categoriaSelectU').val(dato['id_categoria']);
					$('#nombreU').val(dato['nombre']);
					$('#descripcionU').val(dato['descripcion']);
					$('#cantidadU').val(dato['cantidad']);
					$('#precioU').val(dato['precio']);
					$('#puntosU').val(dato['puntos']);

				}
			});
		}

		function eliminaArticulo(idArticulo) {
			alertify.confirm('¿Desea eliminar este articulo?', function() {
				$.ajax({
					type: "POST",
					data: "idarticulo=" + idArticulo,
					url: "../procesos/articulos/eliminarArticulo.php",
					success: function(r) {
						if (r == 1) {
							$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");
							alertify.success("Eliminado con exito!!");
						} else {
							alertify.error("No se pudo eliminar :(");
						}
					}
				});
			}, function() {
				alertify.error('Cancelo !')
			});
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnActualizaarticulo').click(function() {

				datos = $('#frmArticulosU').serialize();
				$.ajax({
					type: "POST",
					data: datos,
					url: "../procesos/articulos/actualizaArticulos.php",
					success: function(r) {
						if (r == 1) {
							$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");
							alertify.success("Actualizado con exito :D");
						} else {
							alertify.error("Error al actualizar :(");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");

			$('#btnAgregaArticulo').click(function() {

				vacios = validarFormVacio('frmArticulos');

				if (vacios > 0) {
					alertify.alert("Debes llenar todos los campos!!");
					return false;
				}

				var formData = new FormData(document.getElementById("frmArticulos"));

				$.ajax({
					url: "../procesos/articulos/insertaArticulos.php",
					type: "post",
					dataType: "html",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,

					success: function(r) {

						if (r == 1) {
							$('#frmArticulos')[0].reset();
							$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");
							alertify.success("Agregado con exito :D");
						} else {
							alertify.error("Fallo al subir el archivo :(");
						}
					}
				});

			});
		});
	</script>

<?php
} else {
	header("location:../index.php");
}
?>