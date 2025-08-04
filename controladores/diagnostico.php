<?php
require_once '../conexion/db.php';

if (isset($_POST['leer_recepcion'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT rc.id_recepcion_cabecera, rc.fecha, CONCAT(c.nombre, ' ', c.apellido) AS cliente FROM recepcion_cabecera rc JOIN cliente c ON rc.id_cliente = c.id_cliente WHERE rc.estado NOT IN ('ANULADO', 'UTILIZADO')");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO diagnostico_cabecera (id_recepcion_cabecera, fecha_diagnostico, id_tecnico, costo_estimado, estado_diagnostico, observaciones) VALUES (:id_recepcion_cabecera, :fecha_diagnostico, :id_tecnico, :costo_estimado, :estado_diagnostico, :observaciones)");
    $query->execute($json_datos);
}

if (isset($_POST['guardar_detalle'])) {
    $json_datos = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO diagnostico_detalle (id_diagnostico, descripcion_prueba, resultado, observaciones) VALUES (:id_diagnostico, :descripcion_prueba, :resultado, :observaciones)");
    $query->execute($json_datos);
}

if (isset($_POST['dameUltimoID'])) {
    dameUltimoID();
}

function dameUltimoID() {
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT MAX(id_diagnostico) AS id_diagnostico FROM diagnostico_cabecera");
    $query->execute();
    if ($query->rowCount()) {
        foreach ($query as $fila) {
            echo $fila['id_diagnostico'];
        }
    } else {
        echo '0';
    }
}

if (isset($_POST['leer_diagnostico'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT dc.id_diagnostico,CONCAT(c.nombre, ' ', c.apellido) as cliente, dc.fecha_diagnostico, dc.costo_estimado, dc.estado_diagnostico, rc.id_recepcion_cabecera FROM diagnostico_cabecera dc JOIN recepcion_cabecera rc "
            . "ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera "
            . "JOIN cliente c "
            . "ON c.id_cliente = rc.id_cliente "
            . "");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_diagnostico_pendiente'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT dc.id_diagnostico, CONCAT(c.nombre, ' ', c.apellido) as cliente, dc.fecha_diagnostico, "
            . "dc.costo_estimado, dc.estado_diagnostico, rc.id_recepcion_cabecera "
            . "FROM diagnostico_cabecera dc JOIN recepcion_cabecera rc "
            . "ON rc.id_recepcion_cabecera = dc.id_recepcion_cabecera "
            . "JOIN cliente c "
            . "ON c.id_cliente = rc.id_cliente "
            . "WHERE dc.estado_diagnostico = 'PENDIENTE'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['anular'])) {
    anular($_POST['anular']);
}

function anular($id) {
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("UPDATE diagnostico_cabecera SET estado_diagnostico = 'ANULADO' WHERE id_diagnostico = $id");
    $query->execute();
}

?>
