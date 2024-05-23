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
</head>
<body>
    <header>
    <?php
                if (isset($_SESSION['nickname'])) {
                    echo '<div class="user-info">Bienvenido: ' . $_SESSION['nickname'] . '</div>';
                }
            ?>
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
        </nav>
    </header>
    <section>
    </section>

    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
