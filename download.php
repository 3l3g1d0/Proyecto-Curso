<?php
    if(isset($_GET['file'])) {
        // Ruta del archivo a descargar
        $file = 'C:\\users\\cf2020236\\Downloads\\laragon\\www\\usuarios\\' . $_SESSION['nickname'] . '\\' . $_GET['file'];

        // Verificar si el archivo existe y es legible
        if (file_exists($file) && is_readable($file)) {
            // Establecer encabezados para forzar la descarga del archivo
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Content-Length: ' . filesize($file));

            // Leer el archivo y enviarlo al cliente
            readfile($file);
            exit;
        } else {
            echo "El archivo no existe o no se puede leer.";
        }
    } else {
        echo "El parámetro 'file' no se ha proporcionado.";
    }
?>