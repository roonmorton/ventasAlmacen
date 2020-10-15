<?php
require_once "../../clases/Conexion.php";




if (isset($_GET['cierre'])) {
    $cierre = $_GET['cierre'];
    $c = new conectar();
    $conexion = $c->conexion();

    $sql = "select caja_ventas.fechaApertura, caja_ventas.fechaCierre, caja_ventas.saldoInicial, sum(ventas.precio) total, caja_ventas.saldoInicial+sum(ventas.precio)  from caja_ventas
    inner join ventas
    on ventas.idCajaVentas = caja_ventas.idcajaVentas
    inner join caja 
    on caja.idCaja = caja_ventas.idCaja
    where caja_ventas.idCajaVentas = $cierre and ventas.tipo_pago = 'E'  AND caja_ventas.fechaCierre IS NOT NULL
    group by ventas.idcajaVentas";

    $result = mysqli_query($conexion, $sql);

    $res = mysqli_fetch_row($result);

    if ($res) {
        $caja = $res;
        $sql = "select ventas.id_venta, concat(clientes.nombre, ' ', clientes.apellido) nombres,  ventas.fechaCompra, articulos.nombre, articulos.descripcion, ventas.precio from caja_ventas
        inner join ventas
        on ventas.idCajaVentas = caja_ventas.idcajaVentas
        inner join caja 
        on caja.idCaja = caja_ventas.idCaja
        inner join clientes
        on clientes.id_cliente = ventas.id_cliente
        inner join articulos 
        on articulos.id_producto = ventas.id_producto
        where caja_ventas.idCajaVentas = $cierre and ventas.tipo_pago = 'E'";
        $result = mysqli_query($conexion, $sql);

?>

        <div class="row">
            <div class="col-sm-6">
                <label>Fecha Apertura</label>
                <input readonly="" type="text" class="form-control input-sm" disabled value=" <?php echo $caja[0]; ?>">
                <label>Fecha Cierre</label>
                <input readonly="" type="text" class="form-control input-sm" disabled value=" <?php echo $caja[1]; ?>">
            </div>
            <div class="col-sm-6">
                <label>Saldo Inicial</label>
                <div class="input-group">
                    <span class="input-group-addon">Q.</span>
                    <input readonly="" type="text" class="form-control input-sm" disabled value=" <?php echo $caja[2]; ?>">
                </div>
                <label>Total ventas</label>
                <div class="input-group">
                    <span class="input-group-addon">Q.</span>
                    <input readonly="" type="text" class="form-control input-sm" disabled value=" <?php echo $caja[3]; ?>">
                </div>
                <label>Total Caja</label>
                <div class="input-group">
                    <span class="input-group-addon">Q.</span>
                    <input readonly="" type="text" class="form-control input-sm" disabled value=" <?php echo $caja[4]; ?>">
                </div>
            </div>
        </div>
<hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>VENTA</th>
                    <th>CLIENTE </th>
                    <th>FECHA COMPRA</th>
                    <th>ARTICULO</th>
                    <th>DESCRIPCION</th>
                    <th>PRECIO</th>

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
                        <td><?php echo "Q. ".$ver[5] ?></td>
                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>
    <?php
    } else {
    ?>
        <h4>No hay datos</h4>
    <?php

    }

    ?>

<?php
} else {
?>

    <h4>No hay cierre</h4>

<?php
}
?>