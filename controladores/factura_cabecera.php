<?php

require_once '../conexion/db.php';

if (isset($_POST['ultimo_registro'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT
fc.nro_factura,
fc.timbrado
FROM factura_cabecera fc
ORDER by fc.id_factura_cabecera desc 
limit 1");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO factura_cabecera"
            . "( nro_factura, fecha, id_cliente, condicion,"
            . " timbrado, estado)"
            . " VALUES (:nro_factura, :fecha, :id_cliente,"
            . " :condicion, :timbrado, :estado)");

    $query->execute($json_datos);

   
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['anular'])) {
    
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE factura_cabecera SET "
            . "estado  = 'ANULADO' "
            . "WHERE id_factura_cabecera = :id");

    $query->execute([
        "id" => $_POST['anular']
    ]);

   
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['activar'])) {
    
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE factura_cabecera SET "
            . "estado  = 'ACTIVO' "
            . "WHERE id_factura_cabecera = :id");

    $query->execute([
        "id" => $_POST['activar']
    ]);

   
}

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT
        fc.id_factura_cabecera,
        fc.fecha,
        fc.nro_factura,
        fc.id_cliente,
        fc.estado,
        CONCAT(c.nombre, ' ', c.apellido) as razon_social,
        fc.condicion,
        SUM(fd.cantidad * fd.precio) as total
        FROM factura_cabecera fc
        JOIN cliente c 
        ON c.id_cliente = fc.id_cliente
        JOIN factura_detalle fd 
        ON fd.id_factura_cabecera =  fc.id_factura_cabecera
        GROUP by fc.id_factura_cabecera
        order by fc.id_factura_cabecera DESC");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

