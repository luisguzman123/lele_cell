<?php
session_start();
require_once '../conexion/db.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT c.id_pedido, c.fecha, c.observacion, c.estado, p.nombre_proveedor FROM pedido_proveedor_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor ORDER BY c.id_pedido DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo "0";
    }
}

if(isset($_POST['leer_activo'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT c.id_pedido, c.fecha, c.observacion, c.estado, c.id_proveedor, p.nombre_proveedor FROM pedido_proveedor_cabecera c JOIN proveedor p ON p.id_proveedor=c.id_proveedor WHERE c.estado='PENDIENTE' ORDER BY c.id_pedido DESC");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['guardar'])){
    $json = json_decode($_POST['guardar'], true);
    $conexion = new DB();
    $pdo = $conexion->conectar();
    if(!isset($_SESSION['id_usuario'])){
        if(isset($_SESSION['usuario'])){
            $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE usuario = :usuario");
            $stmt->execute(['usuario' => $_SESSION['usuario']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user){
                $_SESSION['id_usuario'] = $user['id_usuario'];
            }else{
                http_response_code(401);
                echo 'ID de usuario no disponible';
                exit;
            }
        }else{
            http_response_code(401);
            echo 'ID de usuario no disponible';
            exit;
        }
    }
    $json['id_usuario'] = $_SESSION['id_usuario'];
    $query = $pdo->prepare("INSERT INTO pedido_proveedor_cabecera(fecha, observacion, id_proveedor, id_usuario, estado) VALUES(:fecha,:observacion,:proveedor,:id_usuario,:estado)");
    $query->execute($json);
}

if(isset($_POST['dameUltimoId'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_pedido) AS id FROM pedido_proveedor_cabecera");
    $query->execute();
    $r = $query->fetch(PDO::FETCH_OBJ);
    echo $r ? $r->id : "0";
}

if(isset($_POST['guardar_detalle'])){
    $json = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("INSERT INTO pedido_proveedor_detalle(id_pedido, id_producto, cantidad) VALUES(:id_pedido,:id_producto,:cantidad)");
    $query->execute($json);
}

if(isset($_POST['leer_detalle'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT d.id_producto, p.nombre, d.cantidad FROM pedido_proveedor_detalle d JOIN producto p ON p.id_producto=d.id_producto WHERE d.id_pedido=:id");
    $query->execute(['id'=>$_POST['leer_detalle']]);
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['anular'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE pedido_proveedor_cabecera SET estado='ANULADO' WHERE id_pedido=:id");
    $query->execute(['id'=>$_POST['anular']]);
}

if(isset($_POST['cambiar_estado'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("UPDATE pedido_proveedor_cabecera SET estado='UTILIZADO' WHERE id_pedido=:id");
    $query->execute(['id'=>$_POST['cambiar_estado']]);
}
?>
