
<?php
include_once '../../../../conexion/db.php';

$sql = "SELECT
pc.id_pedido_cabecera,
pc.fecha,
pc.observacion,
pc.estado
FROM pedido_cabecera pc
WHERE pc.id_pedido_cabecera = " . $_GET['id'];

$base = new DB();
$query = $base->conectar()->prepare($sql);
$query->execute();
$cabecera = $query->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Impresion de pedido</title>
        <link rel="stylesheet" href="../../../../assets/css/style.css">
    </head>
    <body>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha : <?= $cabecera['fecha'] ?> </th>
                    <th>Estado: <?= $cabecera['estado'] ?></th>
                </tr>
                <tr>
                    <th colspan="2">Observacion:   <?= $cabecera['observacion'] ?>  </th>
            
            </tr>
            </thead>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <?php
            $query = $base->conectar()->prepare("SELECT
                            p.nombre,
                            pd.cantidad
                            FROM pedido_detalle pd 
                            JOIN producto p 
                            ON p.id_producto =  pd.id_producto
                            WHERE pd.id_pedido_cabecera = " . $_GET['id']);
            $query->execute();
            $detalle = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($detalle as $item) {
                ?>
                <tr>
                    <td><?= $item['nombre'] ?></td>
                    <td><?= $item['cantidad'] ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
