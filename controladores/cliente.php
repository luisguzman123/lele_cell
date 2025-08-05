<?php

require_once '../conexion/db.php';
require_once 'auditoria.php';

if (isset($_POST['leer'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_cliente`, 
CONCAT(nombre, ' ', apellido) as razon_social, `cedula` as ruc,
`telefono`, `estado`
FROM `cliente` 
WHERE estado = 'ACTIVO'");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
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
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("INSERT INTO `cliente`( `nombre`, `apellido`, "
            . "`cedula`, `correo`, `telefono`, `estado`) "
            . "VALUES (:nombre,:apellido,:cedula,:correo,:telefono,:estado)");

    $query->execute($json_datos);
    Auditoria::registrar('INSERT', 'cliente', $pdo->lastInsertId(), json_encode($json_datos));
}


if (isset($_POST['leer_cliente'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_cliente`, `nombre`, `apellido`, "
            . "`cedula`, `correo`, `telefono`, `estado` FROM `cliente`");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}


if (isset($_POST['leer_cliente_id'])) {
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT `id_cliente`, `nombre`, `apellido`, "
            . "`cedula`, `correo`, `telefono`, `estado` FROM `cliente` WHERE id_cliente = :id");

      $query->execute([
        "id" => $_POST['leer_cliente_id']
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
    $query = $pdo->prepare("UPDATE `cliente` SET `nombre`=:nombre,`apellido`=:apellido,"
            . "`cedula`=:cedula,`correo`=:correo,`telefono`=:telefono,`estado`=:estado WHERE "
            . "`id_cliente`=:id_cliente");

    $query->execute($json_datos);
    Auditoria::registrar('UPDATE', 'cliente', $json_datos['id_cliente'], json_encode($json_datos));
}





if (isset($_POST['eliminar'])) {
    
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("DELETE FROM `cliente` WHERE `id_cliente`= :id");

    $query->execute([
        "id" => $_POST['eliminar']
    ]);
    Auditoria::registrar('DELETE', 'cliente', $_POST['eliminar'], null);
}
