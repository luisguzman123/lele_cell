<?php

require_once '../conexion/db.php';

if (isset($_POST['leer_cliente'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_cliente`, `nombre`, `apellido`, "
            . "`cedula`, `correo`, `telefono`, `estado` FROM `cliente` WHERE estado = 'ACTIVO'");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}


if(isset($_POST['leer_id_equipo'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT ce.`id_cliente_equipo`, ce.`id_equipo`, ce.`imei`, "
            . "ce.`tipo_pass`, ce.`pass`, ce.`estado`, e.descripcion, e.marca, e.modelo "
            . "FROM `cliente_equipo` ce JOIN equipo e ON e.id_equipo = ce.id_equipo WHERE ce.`id_cliente` = :id");
    
    $query->execute([
        "id" => $_POST['leer_id_equipo']
    ]);
    
    if($query->rowCount()){
      print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo  "0";
    }
}

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `recepcion_cabecera`(`fecha`, "
            . "`id_cliente`, `id_equipo`, `estado`) VALUES (:fecha,:id_cliente,:id_equipo, :estado)");

    $query->execute($json_datos);

   
}


if (isset($_POST['guardar_detalle'])) {
    $json_datos = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `recepcion_detalle`(`id_recepcion_cabecera`, "
            . "`problema`, `obs`, `estado`) VALUES (:id_recepcion_cabecera,:problema,"
            . ":obs,:estado)");

    $query->execute($json_datos);

   
}

if (isset($_POST['dameUltimoID'])) {
    dameUltimoID();
}

function dameUltimoID() {
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("(SELECT MAX(id_recepcion_cabecera) AS id_recepcion_cabecera "
            . "FROM recepcion_cabecera)");
    $query->execute();

    if ($query->rowCount()) {
        $arreglo = array();
        foreach ($query as $fila) {
            echo $fila['id_recepcion_cabecera'];
        }
    } else {
        echo '0';
    }
}


if (isset($_POST['leer_recepcion'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT rc.`id_recepcion_cabecera`, "
            . "rc.`fecha`, CONCAT(c.nombre, ' ', c.apellido) as nombre_apellido, "
            . "e.descripcion, rc.`estado`, e.modelo, e.marca FROM `recepcion_cabecera` rc "
            . "JOIN cliente c ON rc.id_cliente = c.id_cliente "
            . "JOIN equipo e ON rc.id_equipo = e.id_equipo");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}


//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
if (isset($_POST['anular'])) {
    anular($_POST['anular']);
}

function anular($id) {

    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare("UPDATE recepcion_cabecera SET
            estado = 'ANULADO'
             WHERE id_recepcion_cabecera = $id");

    $query->execute();
}