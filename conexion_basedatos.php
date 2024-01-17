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

// Procesar datos del formulario y realizar la inserción en la base de datos
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$nickname = $_REQUEST['nickname'];
$contrasena = password_hash($_REQUEST['contrasena'], PASSWORD_DEFAULT);

// Consulta preparada
$sql ="INSERT INTO usuarios (nombre, apellido, nickname, contrasena) VALUES ('$nombre','$apellido','$nickname','$contrasena')";

//$sql->bind_param("ssss", $nombre, $apellido, $nickname, $contrasena);

// Ejecutar la consulta
if ($mysqli->query($sql)) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $sql->error;
}
$mysqli->close();
?>