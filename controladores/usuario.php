<?php
require_once '../conexion/db.php';
require_once 'auditoria.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("INSERT INTO `usuario`(`usuario`,`password`,`id_cargo`,`id_permiso`) VALUES (:usuario,MD5(:password),:id_cargo,:id_permiso)");
    $query->execute($json_datos);
    Auditoria::registrar('INSERT', 'usuario', $pdo->lastInsertId(), json_encode($json_datos));
}

if (isset($_POST['leer_usuario'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT u.id_usuario, u.usuario, c.descripcion AS cargo, p.descripcion AS permiso FROM usuario u JOIN cargo c ON u.id_cargo = c.id_cargo JOIN permiso p ON u.id_permiso = p.id_permiso");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_usuario_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT id_usuario, usuario, id_cargo, id_permiso FROM usuario WHERE id_usuario = :id");
    $query->execute([
        "id" => $_POST['leer_usuario_id']
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
    $query = $pdo->prepare("UPDATE usuario SET usuario=:usuario, password=MD5(:password), id_cargo=:id_cargo, id_permiso=:id_permiso WHERE id_usuario=:id_usuario");
    $query->execute($json_datos);
    Auditoria::registrar('UPDATE', 'usuario', $json_datos['id_usuario'], json_encode($json_datos));
}

if (isset($_POST['eliminar'])) {
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("DELETE FROM usuario WHERE id_usuario= :id");
    $query->execute([
        "id" => $_POST['eliminar']
    ]);
    Auditoria::registrar('DELETE', 'usuario', $_POST['eliminar'], null);
}

if (isset($_POST['leer_cargo'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT id_cargo, descripcion FROM cargo WHERE estado = 'ACTIVO'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}

if (isset($_POST['leer_permiso'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT id_permiso, descripcion FROM permiso WHERE estado = 'ACTIVO'");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
?>
