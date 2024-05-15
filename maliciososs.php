<?php
$directorioTemporal = "uploads/";
$archivoSubido = $directorioTemporal . basename($_FILES["fileToUpload"]["name"]);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $archivoSubido)) {
    echo "El archivo ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " ha sido subido.";

    // Llamar al script de Python para analizar el archivo
    $command = escapeshellcmd("python3 proyecto_definitivo(1).py '$archivoSubido'");
    $output = shell_exec($command);
    echo $output;
} else {
    echo "Hubo un error subiendo tu archivo.";
}
?>
