<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado.";
    exit;
}

if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $file = 'C:\\users\\cf2020236\\Downloads\\laragon\\www\\usuarios\\' . $_SESSION['nickname'] . '\\' . $filename;

    if (file_exists($file) && is_readable($file)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($file));

        readfile($file);
        exit;
    } else {
        echo "El archivo no existe o no se puede leer.";
    }
} else {
    echo "El parámetro 'file' no se ha proporcionado.";
}
?>
