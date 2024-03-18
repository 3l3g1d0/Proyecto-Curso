<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["archivo"])) {
    $target_file = $_GET["archivo"];

    $python_executable = "python.exe"; 
    //$python_script = "C:\\Users\\cf2022336\\Downloads\\laragon\\www\\paginawebproyecto\\proyecto_definitivo.py"; 
    $python_script = "C:/Users/cf2022336/Downloads/laragon/www/paginawebproyecto/proyecto_definitivo.py"; 
    $command = $python_executable . " " . $python_script . " " . escapeshellarg($target_file); echo $command;
   
    $output = exec($command);

    echo "Resultado de la detección de virus: " . $output . "!";
} else {
    echo "Error: Archivo no especificado.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detección de Virus</title>
</head>
<body>
    <h1>Detección de Virus</h1>
  
</body>
</html>
