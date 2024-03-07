<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado. <a href='admin.php'>Volver al inicio de sesión</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start; height: 100vh; margin: 0;">
    <div>
        <h1>Panel Configuración Administrador</h1>
    </div>
</body>
</html>
