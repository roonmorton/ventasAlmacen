<?php require_once "dependencias.php" ?>

<!DOCTYPE html>
<html>

<head>
  <title></title>

  <style>
    a{
      color: #fff;
    }
  </style>
</head>

<body>

  <div id="nav">
    <div class="navbar  navbar-fixed-top" data-spy="affix" data-offset-top="100" style="background-color:#0535A4!important;">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> </div>
        <div id="navbar" class="collapse navbar-collapse">

          <ul class="nav navbar-nav navbar-right">

            <li class="active"><a href="/ventasAlmacen/vistas/inicio.php" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
            </li>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> Catalogos <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/ventasAlmacen/vistas/categorias.php">Categorias</a></li>
                <li><a href="/ventasAlmacen/vistas/articulos.php">Articulos</a></li>
              </ul>
            </li>
            <?php
            if ($_SESSION['usuario'] == "admin") :
            ?>
              <li><a href="/ventasAlmacen/vistas/usuarios.php"><span class="glyphicon glyphicon-user"></span> Usuarios</a>
              </li>
            <?php
            endif;
            ?>
            <li><a href="/ventasAlmacen/vistas/clientes.php"><span class="glyphicon glyphicon-user"></span> Clientes</a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart"></span> Movimientos <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/ventasAlmacen/vistas/Caja.php">Caja</a></li>
                <li>
                <li><a href="/ventasAlmacen/vistas/ventas.php"></span> Venta</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> Reportes <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/ventasAlmacen/vistas/ReporteVentas.php">Ventas</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span> Usuario: <?php echo $_SESSION['usuario']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li> <a  href="/ventasAlmacen/procesos/salir.php"><span class="glyphicon glyphicon-off"></span> Salir</a></li>

              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>



</body>

</html>

<script type="text/javascript">
  $(window).scroll(function() {
    if ($(document).scrollTop() > 150) {
      $('.logo').height(200);

    } else {
      $('.logo').height(100);
    }
  });
</script>