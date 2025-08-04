<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO presupuesto_venta_detalle (id_presupuesto_venta, id_producto, cantidad, precio) VALUES ((SELECT max(id_presupuesto_venta) FROM presupuesto_venta_cabecera), :id_producto, :cantidad, :precio)");
    $query->execute($json_datos);
}
?>
