<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>ventas</title>
	<?php require_once "menu.php"; ?>
</head>
<body>

	<div class="container">
	<div id="ventasHechas"></div>

		 <div class="row">
		 	<div class="col-sm-12">
		 		<!-- <div id="ventaProductos"></div>
		 		<div id="ventasHechas"></div> -->
		 	</div>
		 </div>
	</div>
</body>
</html>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#ventasHechas').load('ventas/ventasyReportes.php');

		});

		function esconderSeccionVenta(){
			$('#ventaProductos').hide();
			$('#ventasHechas').hide();
		}

	</script>

<?php 
	}else{
		header("location:../index.php");
	}
 ?>