<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `repuesto`(`nombre_repuesto`, `precio`, `estado`) VALUES (:nombre_repuesto,:precio,:estado)");
    $query->execute($json_datos);
}

if (isset($_POST['leer_repuesto'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_repuesto`, `nombre_repuesto`, `precio`, `estado` FROM `repuesto`");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_repuesto`, `nombre_repuesto`, `precio`, `estado` FROM `repuesto` WHERE estado = 'ACTIVO'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_repuesto_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_repuesto`, `nombre_repuesto`, `precio`, `estado` FROM `repuesto` WHERE id_repuesto = :id");
    $query->execute([
        "id" => $_POST['leer_repuesto_id']
    ]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['actualizar'])) {
    actualizar($_POST['actualizar']);
}

function actualizar($lista)
{
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("UPDATE `repuesto` SET `nombre_repuesto`=:nombre_repuesto,`precio`=:precio,`estado`=:estado WHERE `id_repuesto`=:id_repuesto");
    $query->execute($json_datos);
}

if (isset($_POST['eliminar'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM `repuesto` WHERE `id_repuesto`= :id");
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
}

