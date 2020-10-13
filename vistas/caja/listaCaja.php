<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$sql = "select caja.descripcion, caja_ventas.fechaApertura, caja_ventas. fechaCierre, caja_ventas.saldoInicial,  sum(ventas.precio) as monto, caja.idCaja from caja 
inner join caja_ventas 
on caja.idCaja = caja_ventas.idCaja
left join ventas 
on ventas.idCajaVentas = caja_ventas.idCajaVentas
group by caja_ventas.idCajaVentas";
$result = mysqli_query($conexion, $sql);
?>


<table class="table table-hover">
    <thead>
        <tr>
            <th>CAJA</th>
            <th>FECHA APERTURA </th>
            <th>FECHA CIERRE</th>
            <th>SALDO INICIAL</th>
            <th>MONTO ACTUAL</th>
            <th>CIERRE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($ver = mysqli_fetch_row($result)) :
        ?>

            <tr>
                <th scope="row"><?php echo $ver[0] ?></th>
                <td><?php echo $ver[1] ?></td>
                <td><?php echo $ver[2] ?></td>
                <td><?php echo $ver[3] ?></td>
                <td><?php echo $ver[4] ?></td>
                <td><?php if ($ver[2] == null) { ?>
                    <span class="btn btn-danger btn-xs" onclick="cerrarCaja('<?php echo $ver[5] ?>')">
                        Cerrar caja
                    </span>
                    <?php } ?></td>
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