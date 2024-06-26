<?php
if (isset($_REQUEST['nickname'])) {
    session_start();
    /*
    $servername = "db";
    $username = "user";
    $password = "userpassword";
    $dbname = "usuarios";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Conexion fallida: " . $mysqli->connect_error);
    }
   */
    include "conexion.php";
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $nickname = $_REQUEST['nickname'];
    $contrasena = password_hash($_REQUEST['contrasena'], PASSWORD_DEFAULT);

    $sql ="INSERT INTO usuarios (nombre, apellido, nickname, contrasena) VALUES ('$nombre','$apellido','$nickname','$contrasena')";

    if ($mysqli->query($sql)) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $sql->error;
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Registrarse</title>

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
                    <li><a href="subir.php">Subir</a></li>
                    <li><a href="mis-archivos.php">Mis archivos</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="login-section">
        <div class="login-container">
            <h2>Ingrese sus Datos</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido">Apellidos:</label>
                <input type="text" id="apellido" name="apellido" required>

                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Registrarse</button>
            </form>
        </div>
    </section>

    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
