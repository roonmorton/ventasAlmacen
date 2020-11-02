<?php
session_start();
if (isset($_SESSION['usuario'])) {

	require_once "../clases/Conexion.php";
	$c = new conectar();
	$conexion = $c->conexion();


?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Caja</title>
		<?php require_once "menu.php"; ?>
	</head>

	<body>
		<div class="container">
		</div>
		<div class="container">
			<h3>Caja</h3>
			<br>
			<div class="panel  panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-6">
							<h3 class="panel-title">Listado</h3>
						</div>
						<div class="col-sm-6">
							<span class="btn btn-primary" id="btnAgregaVenta" style="float: right;" data-toggle="modal" data-target="#aperturarCaja">Aperturar caja</span>
							<!-- <span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#actualizaCategoria">
								<span class="glyphicon glyphicon-pencil"></span>
							</span> -->
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div id="listaCajas"></div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="aperturarCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Abrir Caja</h4>
					</div>
					<div class="modal-body">
						<form id="frmACaja">
							<!-- <input type="text" hidden="" id="idcategoria" name="idcategoria"> -->
							<label>Caja</label>
							<!-- <input type="text" id="categoriaU" name="categoriaU" class="form-control input-sm"> -->
							<select class="form-control" id="idCaja" name="idCaja">
								<?php
								$sql = "select idCaja, num, descripcion from caja";
								$result = mysqli_query($conexion, $sql);
								while ($caja = mysqli_fetch_row($result)) :
								?>
									<option value="<?php echo $caja[0] ?>"><?php echo $caja[1] . " || " . $caja[2] ?></option>
								<?php endwhile; ?>
							</select>
							<label for="monto">Monto </label>
							<input type="text" id="monto" name="monto" class="form-control input-sm">
							<label for="descripcion">Descripcion </label>
							<input type="text" id="descripcion" name="descripcion" class="form-control input-sm">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnAperturarCaja" class="btn btn-warning" data-dismiss="modal">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#listaCajas').load('caja/listaCaja.php');


			function esconderSeccionVenta() {
				$('#listaCajas').hide();
			}

			function agregaDato(idCategoria, categoria) {
				$('#idcategoria').val(idCategoria);
				$('#categoriaU').val(categoria);
			}




			$('#btnAperturarCaja').click(function() {

				datos = $('#frmACaja').serialize();
				$.ajax({
					type: "POST",
					data: datos,
					url: "../procesos/caja/aperturarCaja.php",
					success: function(r) {
						if (r == 0) {
							$('#listaCajas').load('caja/listaCaja.php');
							alertify.success("Caja aperturada con exito");
						} else if(r == 1) {
							alertify.error("Caja ya se encuentra aperturada");
						}else{
							alertify.error("No se pudo aperturar la caja");

						}
					}
				});
			});
		});
		function cerrarCaja(idCaja) {
            alertify.confirm('¿Desea cerrar la caja?', function() {
                $.ajax({
                    type: "POST",
                    data: "idCaja=" + idCaja,
                    url: "../procesos/caja/cerrarCaja.php",
                    success: function(r) {
                        if (r == 1) {
                            $('#listaCajas').load('caja/listaCaja.php');
                            alertify.success("Caja cerrada con exito!!");
                        } else {
                            alertify.error("No se pudo cerrar la caja");
                        }
                    }
                });
            }, function() {
                alertify.error('Cancelo !')
            });
        }
	</script>

<?php
} else {
	header("location:../index.php");
}
?>