<?php
session_start();


if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado. <a href='conexion_login.php'>Volver al login</a>";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $nombreArchivo = $_FILES['fileToUpload']['name'];
    $temporal = $_FILES['fileToUpload']['tmp_name'];
    $nickname = $_SESSION['nickname'];
    $carpetaUsuario = $_SERVER['DOCUMENT_ROOT'] . "/usuarios/$nickname/";

    if(!file_exists($carpetaUsuario)){
        mkdir($carpetaUsuario, 0777, true); 
    }

    $rutaDestino = $carpetaUsuario . basename($nombreArchivo);

    if (move_uploaded_file($temporal, $rutaDestino)) {
        echo "Archivo subido con éxito.";

      
        $comando = escapeshellcmd('C:\\Users\\cf2022336\\Downloads\\laragon\\bin\\python\\python-3.10\\python.exe C:\\Users\\cf2022336\\Downloads\\laragon\\www\\paginawebproyecto\\proyecto_definitvo.py "' . $rutaDestino . '"');
        $output = shell_exec($comando . ' 2>&1'); 
        echo $output; 
    } else {
        echo "Error al subir el archivo.";
    }
}

?>
