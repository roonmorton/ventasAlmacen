<?php

require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();
?>

<h3>Ventas</h3>
<hr>
<div class="panel panel-info">
	<div class="panel-heading">
	</div>
	<div class="panel-body">
		<form id="frmVentasProductos">
			<label for="">Caja</label>
			<select class="form-control" id="idCaja" name="idCaja">
				<?php
				$sql = "select idCaja, num, descripcion from caja";
				$result = mysqli_query($conexion, $sql);
				while ($caja = mysqli_fetch_row($result)) :
				?>
					<option value="<?php echo $caja[0] ?>"><?php echo $caja[1] . " || " . $caja[2] ?></option>
				<?php endwhile; ?>
			</select>
			<label>Cliente</label>
			<select class="form-control" id="clienteVenta" name="clienteVenta">
				<option value="">Selecciona</option>
				
				<?php
				$sql = "SELECT id_cliente,nombre,apellido 
				from clientes";
				$result = mysqli_query($conexion, $sql);
				while ($cliente = mysqli_fetch_row($result)) :
				?>
					<option value="<?php echo $cliente[0] ?>"><?php echo $cliente[2] . " " . $cliente[1] ?></option>
				<?php endwhile; ?>
			</select>
			<label>Tipo de Pago</label>
			<select class="form-control" id="formaPago" name="formaPago">
				<option value="E">Efectivo</option>
				<option value="T">Tarjeta</option>
			</select>
			<hr>
			<div class="row">
				<div class="col-sm-8">
					<label>Producto</label>
					<select class="form-control " id="productoVenta" name="productoVenta">
						<option value="A">Selecciona</option>
						<?php
						$sql = "SELECT id_producto,
				nombre
				from articulos";
						$result = mysqli_query($conexion, $sql);

						while ($producto = mysqli_fetch_row($result)) :
						?>
							<option value="<?php echo $producto[0] ?>"><?php echo $producto[1] ?></option>
						<?php endwhile; ?>
					</select>

					<div class="row">
						<div class="col-sm-6">
							<label>Existencias</label>
							<input readonly="" type="text" class="form-control input-sm" id="cantidadV" name="cantidadV">
						</div>
						<div class="col-sm-6">
							<label>Precio</label>
							<div class="input-group">
								<span class="input-group-addon">Q.</span>
								<input readonly="" type="text" class="form-control input-sm" id="precioV" name="precioV">
							</div>
						</div>
					</div>


					<label>Descripcion</label>
					<textarea readonly="" id="descripcionV" name="descripcionV" class="form-control input-sm"></textarea>
				</div>
				<div class="col-sm-4">
					<div id="imgProducto"></div>
				</div>
			</div>
			<br>
			<span class="btn btn-primary" id="btnAgregaVenta">Agregar producto</span>
			<span class="btn btn-danger" id="btnVaciarVentas">Vaciar ventas</span>
			<span class="btn btn-success" onclick="crearVenta()"> Generar venta
			</span>
		</form>
	</div>
</div>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Detalle</h3>
	</div>
	<div class="panel-body">
		<div id="tablaVentasTempLoad"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");

		$('#productoVenta').change(function() {
			$.ajax({
				type: "POST",
				data: "idproducto=" + $('#productoVenta').val(),
				url: "../procesos/ventas/llenarFormProducto.php",
				success: function(r) {
					dato = jQuery.parseJSON(r);

					$('#descripcionV').val(dato['descripcion']);
					$('#cantidadV').val(dato['cantidad']);
					$('#precioV').val(dato['precio']);
					$("#imgProducto").children("img").eq(0).remove();
					$('#imgProducto').prepend('<img class="img-thumbnail" id="imgp" width="180"  src="' + dato['ruta'] + '" />');
				}
			});
		});

		$('#btnAgregaVenta').click(function() {
			vacios = validarFormVacio('frmVentasProductos');

			if (vacios > 0) {
				alertify.alert("Debes llenar todos los campos!!");
				return false;
			}

			datos = $('#frmVentasProductos').serialize();
			$.ajax({
				type: "POST",
				data: datos,
				url: "../procesos/ventas/agregaProductoTemp.php",
				success: function(r) {
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				}
			});
		});

		$('#btnVaciarVentas').click(function() {

			$.ajax({
				url: "../procesos/ventas/vaciarTemp.php",
				success: function(r) {
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				}
			});
		});

	});
</script>

<script type="text/javascript">
	function quitarP(index) {
		$.ajax({
			type: "POST",
			data: "ind=" + index,
			url: "../procesos/ventas/quitarproducto.php",
			success: function(r) {
				$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				alertify.success("Se quito el producto :D");
			}
		});
	}

	function crearVenta() {
		$.ajax({
			url: "../procesos/ventas/crearVenta.php",
			success: function(r) {
				/* if (r > 0) {
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
					$('#frmVentasProductos')[0].reset();
					alertify.alert("Venta creada con exito, consulte la informacion de esta en ventas hechas :D");
				} else if (r == 0) {
					alertify.alert("No hay lista de venta!!");
				} else {
					alertify.error("No se pudo crear la venta");
				} */
				if (r > 0) {
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
					$('#frmVentasProductos')[0].reset();
					alertify.alert("Venta creada con exito, consulte la informacion de esta en ventas hechas :D");
				} else if (r == 0) {
					alertify.alert("No hay lista de venta!!");
				} else if (r == -1) {
					alertify.error("No hay existencia de producto");
				} else if (r == -2) {
					alertify.error("Caja no aperturada");
				} else {
					alertify.error("No se pudo crear la venta" + r);
				}
			}
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#clienteVenta').select2();
		$('#productoVenta').select2();

	});
</script>