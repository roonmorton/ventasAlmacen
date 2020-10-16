<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$sql = "select caja.descripcion, cv.fechaApertura, cv. fechaCierre, cv.saldoInicial, 
(select sum(v.precio) from ventas as v where v.idCajaVentas = cv.idCajaVentas and v.tipo_pago = 'E') monto,
caja.idCaja, cv.idCajaVentas  from caja 
inner join caja_ventas cv
on caja.idCaja = cv.idCaja
left join ventas as ve
on ve.idCajaVentas = cv.idCajaVentas
group by cv.idCajaVentas";
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
            <th>REPORTE</th>

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
                <td><?php echo 'Q. ' . $ver[3] ?></td>
                <td><?php echo $ver[4] == null ? 'Q. 0' : 'Q. '.$ver[4] ?></td>
                <td>
                    <?php if ($ver[2] == null) { ?>
                        <span class="btn btn-danger btn-xs" onclick="cerrarCaja('<?php echo $ver[5] ?>')">
                            Cerrar caja
                        </span>
                    <?php } ?></td>
                <td>
                    <?php if ($ver[2] != null) { ?>
                        <a class="btn btn-success btn-xs" href="reporteCierreCaja.php?cierre=<?php echo $ver[6] ?>" >
                            Reporte
                        </a>
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