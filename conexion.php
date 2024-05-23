<?php
    $servername = "db";
    $username = "user";
    $password = "userpassword";
    $dbname = "usuarios";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Conexion fallida: " . $mysqli->connect_error);
    }
?>
