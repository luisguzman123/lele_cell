<?php

require_once '../conexion/db.php';
require_once 'auditoria.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("INSERT INTO `producto`(`nombre`, `precio`, `stock`, `estado`, `iva`) VALUES (:nombre,:precio,:stock,:estado,:iva)");
    $query->execute($json_datos);
    Auditoria::registrar('INSERT', 'producto', $pdo->lastInsertId(), json_encode($json_datos));
}

if (isset($_POST['leer_producto'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_producto`, `nombre`, `precio`, `stock`, `estado`, `iva` FROM `producto`");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_producto`, `nombre`, `precio`, `stock`, `estado`, `iva` FROM `producto` WHERE estado = 'ACTIVO'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_producto_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_producto`, `nombre`, `precio`, `stock`, `estado`, `iva` FROM `producto` WHERE id_producto = :id");
    $query->execute([
        "id" => $_POST['leer_producto_id']
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
    $pdo = $base_datos->conectar();
    $query = $pdo->prepare("UPDATE `producto` SET `nombre`=:nombre,`precio`=:precio,`stock`=:stock,`estado`=:estado,`iva`=:iva WHERE `id_producto`=:id_producto");
    $query->execute($json_datos);
    Auditoria::registrar('UPDATE', 'producto', $json_datos['id_producto'], json_encode($json_datos));
}

if (isset($_POST['eliminar'])) {
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("DELETE FROM `producto` WHERE `id_producto`= :id");
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
    Auditoria::registrar('DELETE', 'producto', $_POST['eliminar'], null);
}
