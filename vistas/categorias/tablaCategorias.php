<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id_categoria,nombreCategoria 
					FROM categorias";
$result = mysqli_query($conexion, $sql);
?>


<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($ver = mysqli_fetch_row($result)) :
        ?>

            <tr>
                <th scope="row"><?php echo $ver[0] ?></th>
                <td><?php echo $ver[1] ?></td>
                <td>
                    <span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#actualizaCategoria" onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo $ver[1] ?>')">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </span>
                </td>
                <td>
                    <span class="btn btn-danger btn-xs" onclick="eliminaCategoria('<?php echo $ver[0] ?>')">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                </td>
            </tr>

        <?php endwhile; ?>
    </tbody>
</table>


<!-- <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
    <caption><label>Categorias :D</label></caption>
    <tr>
        <td>Categoria</td>
        <td>Editar</td>
        <td>Eliminar</td>
    </tr>


</table> -->