<?php
$servername = "sql208.infinityfree.com";
$username = "if0_35033314";
$password = "fyr2jILbVGJE443";
$dbname = "if0_35033314_relacional";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $nombreArchivo = $_FILES['file']['name'];
    $contenidoArchivo = file_get_contents($_FILES['file']['tmp_name']);

   
    $stmt = $conn->prepare("INSERT INTO archivos (nombre, contenido) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombreArchivo, $contenidoArchivo);

    if ($stmt->execute()) {
        echo "Archivo subido y registrado en la base de datos con éxito.";
    } else {
        echo "Error al subir el archivo: " . $conn->error;
    }

   
    $stmt->close();
}


$conn->close();
?>
