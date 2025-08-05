<?php
require_once '../conexion/db.php';

class Auditoria {
    public static function registrar($accion, $tabla, $registroId = null, $detalles = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $usuario = $_SESSION['usuario'] ?? 'anonimo';
        $idUsuario = $_SESSION['id_usuario'] ?? null;

        $db = new DB();
        $pdo = $db->conectar();
        $stmt = $pdo->prepare("INSERT INTO auditoria (id_usuario, usuario, accion, tabla, id_registro, detalles) VALUES (:id_usuario, :usuario, :accion, :tabla, :id_registro, :detalles)");
        $stmt->execute([
            'id_usuario' => $idUsuario,
            'usuario' => $usuario,
            'accion' => $accion,
            'tabla' => $tabla,
            'id_registro' => $registroId,
            'detalles' => $detalles
        ]);
    }
}

if (isset($_POST['listar'])) {
    $db = new DB();
    $pdo = $db->conectar();
    $sql = "SELECT id_auditoria, usuario, accion, tabla, id_registro, detalles, fecha FROM auditoria ORDER BY fecha DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount()) {
        print_r(json_encode($stmt->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo "0";
    }
}
?>
