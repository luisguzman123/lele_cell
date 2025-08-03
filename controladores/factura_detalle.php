<?php

require_once '../conexion/db.php';
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO factura_detalle"
            . "(id_factura_cabecera, id_producto, cantidad, precio)"
            . " VALUES ((SELECT max(id_factura_cabecera) 
            FROM `factura_cabecera`), :id_producto, :cantidad, :precio)");

    $query->execute($json_datos);

   
}