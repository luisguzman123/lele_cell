<?php
session_start();
require_once '../conexion/db.php';
require_once 'auditoria.php';

if(isset($_POST['leer'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT c.id_compra, c.fecha, c.total, c.estado, c.id_proveedor, p.nombre_proveedor FROM compra_cabecera c LEFT JOIN proveedor p ON p.id_proveedor=c.id_proveedor ORDER BY c.id_compra DESC");
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
    $query = $pdo->prepare("INSERT INTO compra_cabecera(fecha, observacion, id_proveedor, id_orden, total_exenta, total_iva5, total_iva10, total, id_usuario, estado) VALUES(:fecha,:observacion,:id_proveedor,:id_orden,:total_exenta,:total_iva5,:total_iva10,:total,:id_usuario,:estado)");
    $query->execute($json);
    Auditoria::registrar('INSERT', 'compra_cabecera', $pdo->lastInsertId(), json_encode($json));
}

if(isset($_POST['dameUltimoId'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT MAX(id_compra) AS id FROM compra_cabecera");
    $query->execute();
    $r = $query->fetch(PDO::FETCH_OBJ);
    echo $r ? $r->id : '0';
}

if(isset($_POST['guardar_detalle'])){
    $json = json_decode($_POST['guardar_detalle'], true);
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("INSERT INTO compra_detalle(id_compra, id_producto, cantidad, precio) VALUES(:id_compra,:id_producto,:cantidad,:precio)");
    $query->execute($json);
    Auditoria::registrar('INSERT', 'compra_detalle', null, json_encode($json));
}

if(isset($_POST['anular'])){
    $conexion = new DB();
    $pdo = $conexion->conectar();
    $query = $pdo->prepare("UPDATE compra_cabecera SET estado='ANULADO' WHERE id_compra=:id");
    $query->execute(['id'=>$_POST['anular']]);
    Auditoria::registrar('UPDATE', 'compra_cabecera', $_POST['anular'], 'ANULADO');
}

if(isset($_POST['resumen'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT COUNT(DISTINCT cc.id_compra) AS cantidad, IFNULL(SUM(cd.cantidad * cd.precio),0) AS total FROM compra_cabecera cc JOIN compra_detalle cd ON cd.id_compra = cc.id_compra WHERE cc.estado <> 'ANULADO'");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}

if(isset($_POST['comprasMes'])){
    $conexion = new DB();
    $query = $conexion->conectar()->prepare("SELECT DATE_FORMAT(cc.fecha,'%Y-%m') AS mes, IFNULL(SUM(cd.cantidad * cd.precio),0) AS monto FROM compra_cabecera cc JOIN compra_detalle cd ON cd.id_compra = cc.id_compra WHERE cc.estado <> 'ANULADO' GROUP BY DATE_FORMAT(cc.fecha,'%Y-%m') ORDER BY mes");
    $query->execute();
    if($query->rowCount()){
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    }else{
        echo '0';
    }
}
?>
