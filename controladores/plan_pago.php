<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar_cabecera'])) {
    $json_datos = json_decode($_POST['guardar_cabecera'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO plan_pago_cabecera (id_factura_cabecera, total) VALUES ((SELECT max(id_factura_cabecera) FROM factura_cabecera), :total)");
    $query->execute($json_datos);
}

if (isset($_POST['guardar_detalle'])) {
    $json_datos = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO plan_pago_detalle (id_plan, nro_cuota, fecha_vencimiento, monto_cuota, estado) VALUES ((SELECT max(id_plan) FROM plan_pago_cabecera), :nro_cuota, :fecha_vencimiento, :monto_cuota, 'PENDIENTE')");
    $query->execute($json_datos);
}

?>
