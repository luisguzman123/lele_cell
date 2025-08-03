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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      background: #ffffff;
    }
    .login-card .btn-primary {
      background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
      border: none;
    }
    .login-card .btn-primary:hover {
      opacity: 0.9;
    }
    .login-card .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(106, 115, 255, 0.25);
      border-color: #6B73FF;
    }
    .login-logo {
      display: block;
      margin: 0 auto 1.5rem;
      height: 80px;
    }
    .alert-danger {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <!-- Logo -->
    <h2 style="text-align: center;">Iniciar sesión</h2>
<!--    <img src="dist/assets/img/01 - Logotipo Oficial.png" 
         alt="LR CEL Logo" 
         class="login-logo">-->

    <form method="post">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" 
               id="usuario" 
               name="usuario" 
               class="form-control" 
               placeholder="Ingresa tu usuario" 
               required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" 
               id="password" 
               name="password" 
               class="form-control" 
               placeholder="Ingresa tu contraseña" 
               required>
      </div>

      <?php if ($mensaje): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($mensaje) ?>
      </div>
      <?php endif; ?>

      <button type="submit" class="btn btn-primary w-100">
        Ingresar
      </button>
    </form>
  </div>

  <!-- Bootstrap JS (opcional si no necesitas componentes JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
