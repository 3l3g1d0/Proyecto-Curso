<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "usuarios";

// Crear la conexión
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Procesar datos del formulario 
$nickname = $_REQUEST['nickname'];
$contrasena = $_REQUEST['contrasena'];

// Consulta preparada para obtener la contraseña almacenada en la base de datos
$sql = "SELECT contrasena FROM usuarios WHERE nickname = '$nickname'"; 
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$contrasena_guardada=$row["contrasena"];

// Verificar la contraseña
if (password_verify($contrasena, $contrasena_guardada)) {
    echo "Inicio de sesión exitoso";
} else {
    echo "Error: Usuario o contraseña incorrectos";
}

$mysqli->close();
?>
