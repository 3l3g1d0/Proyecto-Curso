<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Subir Archivos</title>

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
        <h1>Bienvenido a la Página de Subir Archivos</h1>
        <nav class="top-nav">
            <div class="menu-container">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="conexion_login.php">Log In</a></li>
                    <li><a href="conexion_register.php">Registro</a></li>
                    <li><a href="mis-archivos.php">Mis archivos</a></li>
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
                <p>Subir Archivo</p>
                <form action="upload_file.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <button type="submit" class="start-button" name="submit">Start</button>
                </form>
            </div>
        </div>

       

    </section>

    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
