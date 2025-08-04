<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO `permiso`(`descripcion`, `estado`) VALUES (:descripcion,:estado)");
    $query->execute($json_datos);
}

if (isset($_POST['leer_permiso'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_permiso`, `descripcion`, `estado` FROM `permiso`");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_permiso_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_permiso`, `descripcion`, `estado` FROM `permiso` WHERE id_permiso = :id");
    $query->execute([
        "id" => $_POST['leer_permiso_id']
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
    $query = $base_datos->conectar()->prepare("UPDATE `permiso` SET `descripcion`=:descripcion,`estado`=:estado WHERE `id_permiso`=:id_permiso");
    $query->execute($json_datos);
}

if (isset($_POST['eliminar'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("DELETE FROM `permiso` WHERE `id_permiso`= :id");
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
}
?>

