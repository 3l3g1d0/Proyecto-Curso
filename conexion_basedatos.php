<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "usuarios";


$mysqli = new mysqli($servername, $username, $password, $dbname);


if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}


$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$nickname = $_REQUEST['nickname'];
$contrasena = password_hash($_REQUEST['contrasena'], PASSWORD_DEFAULT);


$sql ="INSERT INTO usuarios (nombre, apellido, nickname, contrasena) VALUES ('$nombre','$apellido','$nickname','$contrasena')";




if ($mysqli->query($sql)) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $sql->error;
}
$mysqli->close();
?>
