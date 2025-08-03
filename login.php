<?php
session_start();
require_once 'conexion/db.php';

$db = new DB();
$pdo = $db->conectar();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM usuario WHERE usuario = ? AND password = ?');
    $stmt->execute([$usuario, md5($password)]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
        header('Location: index.php');
        exit;
    } else {
        $mensaje = 'No puede ingresar';
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <form method="post">
        <label>Usuario: <input type="text" name="usuario"></label><br>
        <label>Contraseña: <input type="password" name="password"></label><br>
        <button type="submit">Ingresar</button>
    </form>
    <?php if ($mensaje): ?>
    <p style="color:red;">
        <?= htmlspecialchars($mensaje) ?>
    </p>
    <?php endif; ?>
</body>
</html>

