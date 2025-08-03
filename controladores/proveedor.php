<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `proveedor`(`nombre_proveedor`, `ruc`, `telefono`, `estado`) VALUES (:nombre_proveedor,:ruc,:telefono,:estado)");
    $query->execute($json_datos);
}

if (isset($_POST['leer_proveedor'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_proveedor`, `nombre_proveedor`, `ruc`, `telefono`, `estado` FROM `proveedor`");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_proveedor`, `nombre_proveedor`, `ruc`, `telefono`, `estado` FROM `proveedor` where estado = 'ACTIVO'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
if (isset($_POST['leer_proveedor'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_proveedor`, `nombre_proveedor`, `ruc`, `telefono`, `estado` FROM `proveedor`");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_proveedor_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_proveedor`, `nombre_proveedor`, `ruc`, `telefono`, `estado` FROM `proveedor` WHERE id_proveedor = :id");
    $query->execute([
        "id" => $_POST['leer_proveedor_id']
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
    $query = $base_datos->conectar()->prepare("UPDATE `proveedor` SET `nombre_proveedor`=:nombre_proveedor,`ruc`=:ruc,`telefono`=:telefono,`estado`=:estado WHERE `id_proveedor`=:id_proveedor");
    $query->execute($json_datos);
}

if (isset($_POST['eliminar'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM `proveedor` WHERE `id_proveedor`= :id");
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
}
