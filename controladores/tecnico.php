<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `tecnico`(`nombre_tecnico`, `cedula`, `telefono`, `estado`) VALUES (:nombre_tecnico,:cedula,:telefono,:estado)");
    $query->execute($json_datos);
}

if (isset($_POST['leer_tecnico'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_tecnico`, `nombre_tecnico`, `cedula`, `telefono`, `estado` FROM `tecnico`");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_tecnico`, `nombre_tecnico`, `cedula`, `telefono`, `estado` FROM `tecnico` where estado = 'ACTIVO'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_tecnico_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_tecnico`, `nombre_tecnico`, `cedula`, `telefono`, `estado` FROM `tecnico` WHERE id_tecnico = :id");
    $query->execute([
        "id" => $_POST['leer_tecnico_id']
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
    $query = $base_datos->conectar()->prepare("UPDATE `tecnico` SET `nombre_tecnico`=:nombre_tecnico,`cedula`=:cedula,`telefono`=:telefono,`estado`=:estado WHERE `id_tecnico`=:id_tecnico");
    $query->execute($json_datos);
}

if (isset($_POST['eliminar'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM `tecnico` WHERE `id_tecnico`= :id");
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
}

