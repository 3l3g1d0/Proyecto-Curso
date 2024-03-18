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
    <title>Subir Archivos</title>
 
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
        <h1>Bienvenido a la Página de Subir Archivos</h1>
        <nav class="top-nav">
            <div class="menu-container">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="conexion_login.php">Log In</a></li>
                    <li><a href="conexion_register.php">Registro</a></li>
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
