<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado. <a href='conexion_login.php'>Volver al login</a>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Mi Página de Inicio</title>
    <style>
        .user-info {
            opacity: 0; 
            transition: opacity 0.5s ease; 
        }
        .user-info.show {
            opacity: 1; 
        }
    </style>
</head>
<body>
    <header>
        <h1>ASIX Projecte</h1>
        <nav class="top-nav">
            <div class="menu-container">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="conexion_login.php">Log In</a></li>
                    <li><a href="conexion_register.php">Registrarse</a></li>
                    <li><a href="subir.php">Subir</a></li>
                </ul>
            </div>
            <?php
            
            if (isset($_SESSION['nickname'])) {
                echo '<div class="user-info">' . $_SESSION['nickname'] . '</div>';
            }
            ?>
        </nav>
    </header>
    <section class="upload-section">
        <div class="upload-column">
            <div class="start-box">
                <p>Mis archivos</p>
                <a type="button" class="start-button" href="./mis-archivos.php?action=get_files">Recoger</a>
            </div>
        </div>

    <script>
        function openFolder() {
            window.location.href = 'mis-archivos.php?action=get_files'; 
        }
    </script>
    <?php
    if(isset($_GET['action']) && $_GET['action'] == 'get_files') {
        
        if (isset($_SESSION['nickname'])) {
            $nickname = $_SESSION['nickname'];

            
            $dir = 'C:\\users\\cf2022336\\Downloads\\laragon\\www\\usuarios\\' . $nickname;

            
            if (is_dir($dir)) {
                
                $files = scandir($dir);

                
                echo "<h2>Archivos en la carpeta $nickname:</h2>";
                echo "<ul>";
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        echo "<li>$file</li>";
                    }
                }
                echo "</ul>";
            } else {
                echo "<p>La carpeta para el usuario $nickname no existe.</p>";
            }
        } else {
            echo "<p>No se ha iniciado sesión o no se ha establecido un nickname.</p>";
        }
    }
    else{
        echo "";
    }
    ?>
    </section>
    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
