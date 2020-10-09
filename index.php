<?php 
	
	require_once "clases/Conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$sql="SELECT * from usuarios where email='admin'";
	$result=mysqli_query($conexion,$sql);
	$validar=0;
	if(mysqli_num_rows($result) > 0){
		$validar=1;
	}
 ?>


<!DOCTYPE html>
<html>

<head>
    <title>Login de usuario</title>
    <!-- <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
		integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
		<!-- <link rel="stylesheet" href="librerias/fontAwesome-5.10/all.css"> -->
		<link rel="stylesheet" href="librerias/bootstrap-4/bootstrap.min.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="js/funciones.js"></script>
</head>

<body style="background-color: #fff">
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">

                <div class="card">
                    <div class="card-header text-white bg-info ">
                        <h4>Sistema ventas</h4>
                    </div>
                    <div class="card-body">
                        <!-- <div style="text-align:center">
					<i class="fas fa-warehouse fa-3x"></i>
					</div> -->

                        <br>
                        <form id="frmLogin" autocomplete="on">
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <div class="input-group mb-3 required form-group ">
                                    <input type="text" class="form-control" placeholder="" aria-label="Usuario"
                                        name="usuario" id="usuario" autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <div class="input-group mb-3 required form-group">
                                    <input type="password" class="form-control" placeholder="" aria-label="Contraseña"
                                        name="password" id="password">
                                    <div class="input-group-append cursor-pointer">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i class="fa fa-key"></i>
                                            <!--  <i class="fa fa-eye-slash" *ngIf="!hidePassword"></i> -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- <label>Usuario*</label>
                            <input type="text" class="form-control input-sm" name="usuario" id="usuario" autofocus>
                            <label>Contraseña*</label>
                            <input type="password" name="password" id="password" class="form-control input-sm"> -->
							<br>
							<button type="submit" class="btn btn-info " id="entrarSistema" style="width: 100%">Entrar</button>
                           <!--  <span class="btn btn-info " id="entrarSistema" style="width: 100%">Entrar</span> -->
                            <?php  if(!$validar): ?>
                                
                            <a href="registro.php" class="btn btn-danger " style="width: 100%; margin-top: 1em">Registrar</a>
                            <?php endif; ?>
                        </form>

                        <br>
                    </div>
                </div>
                <!-- <div class="panel panel-primary">
                    <div class="panel panel-heading">Ventas</div>
                    <div class="panel panel-body">
                        <p>
                            <img src="img/ventas.jpg" height="190">
                        </p>
                        <form id="frmLogin">
                            <label>Usuario</label>
                            <input type="text" class="form-control input-sm" name="usuario" id="usuario">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control input-sm">
                            <p></p>
                            <span class="btn btn-primary btn-sm" id="entrarSistema">Entrar</span>
                            <?php  if(!$validar): ?>
                            <a href="registro.php" class="btn btn-danger btn-sm">Registrar</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div> -->
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
	</script> -->
	<script src="librerias/bootstrap-4/bootstrap.min.js"></script>
</body>

</html>

<script type="text/javascript">
$(document).ready(function() {

    $("#frmLogin").submit(function(event) {
        login();
	});
	
    $('#entrarSistema').click(function() {
        login();
	});
	
	function login(){
		vacios = validarFormVacio('frmLogin');
        if (vacios > 0) {
            alert("Debes llenar todos los campos!!");
            return false;
        }
        datos = $('#frmLogin').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "procesos/regLogin/login.php",
            success: function(r) {

                if (r == 1) {
                    window.location = "vistas/inicio.php";
                } else {
                    alert("No se pudo acceder :(");
                }
            }
        });
	}
});
</script>