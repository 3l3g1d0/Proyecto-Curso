<?php
session_start();
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
                    <li><a href="conexion_login.php">Log In</a></li>
                    <li><a href="conexion_register.php">Registrarse</a></li>
                    <li><a href="subir.php">Subir</a></li>
                    <li><a href="mis-archivos.php">Mis archivos</a></li>
                </ul>
            </div>
            <?php
           
            if (isset($_SESSION['nickname'])) {
                echo '<div class="user-info">' . $_SESSION['nickname'] . '</div>';
            }
            ?>
        </nav>
    </header>

    <section>
    </section>

    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>