<?php
    if(isset($_GET['file'])) {
        
        $file = 'C:\\users\\cf2020236\\Downloads\\laragon\\www\\usuarios\\' . $_SESSION['nickname'] . '\\' . $_GET['file'];

       
        
        if (file_exists($file) && is_readable($file)) {
           
            
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
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
