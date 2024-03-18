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
            opacity: 0; /* Inicialmente oculto */
            transition: opacity 0.5s ease; /* Transición de opacidad */
        }
        .user-info.show {
            opacity: 1; /* Mostrar el nombre de usuario */
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
            // Muestra el nombre de usuario si está presente en la sesión
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
                <button type="button" class="start-button" onclick="openFolder()">Recoger</button>
            </div>
        </div>
    </section>
    <script>
        function openFolder() {
            window.location.href = 'mis-archivos.php?action=get_files'; // Hacer una solicitud al servidor para obtener la lista de archivos
        }
    </script>
    
    <?php
    if(isset($_GET['action']) && $_GET['action'] == 'get_files') {
        // Verificar si el usuario ha iniciado sesión y si se ha establecido el nickname en la sesión
        if (isset($_SESSION['nickname'])) {
            $nickname = $_SESSION['nickname'];

            // Construir la ruta de la carpeta basada en el nickname
            $dir = 'C:\\users\\cf2020236\\Downloads\\laragon\\www\\usuarios\\' . $nickname;

            // Verificar si la carpeta existe
            if (is_dir($dir)) {
                // Abrir la carpeta
                $files = scandir($dir);

                // Mostrar los archivos en la carpeta
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
    ?>
    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>