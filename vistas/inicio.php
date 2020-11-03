<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>inicio</title>
	<?php require_once "menu.php"; ?>
</head>
<body>

	<div class="container">
		<h1 style="text-align: center;">Bienvenido</h1>
		<hr>
		<img src="../img/compras.jpg" alt="" style="width: 100%;">
	</div>
</body>
</html>
<?php 
	}else{
		header("location:../index.php");
	}
 ?>