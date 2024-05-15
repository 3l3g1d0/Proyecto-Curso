<?php
// Verifica si se ha pasado el nombre del archivo en la URL
if(isset($_GET['nombre_archivo'])) {
    // Obtiene el nombre del archivo de la URL
    $nombreArchivo = $_GET['nombre_archivo'];
    
    // Ruta del directorio donde se encuentran los archivos
    $directorioArchivos = 'C:/Users/cf2022336/Downloads/laragon/www/archivos/';

    // Ruta completa al archivo
    $rutaArchivo = $directorioArchivos . $nombreArchivo;

    // Verificar si el archivo existe
    if (file_exists($rutaArchivo)) {
        // Configurar las cabeceras   la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($rutaArchivo));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaArchivo));
        // Leer el archivo y enviar su contenido al navegador
        readfile($rutaArchivo);
        exit;
    } else {
        // Si el archivo no existe, mostrar un mensaje de error
        echo "El archivo no existe.";
    }
} else {
    // Si no se ha pasado el nombre del archivo en la URL, mostrar un mensaje de error
    echo "Nombre de archivo no especificado.";
}
?>