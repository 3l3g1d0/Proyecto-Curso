<?php
if (isset($_REQUEST['nickname'])) {
    session_start(); 

    $servername = "127.0.0.1";
    $username = "admin";
    $password = "admin";
    $dbname = "usuarios";

    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

   
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    
    $nickname = $_REQUEST['nickname'];
    $contrasena = $_REQUEST['contrasena'];

   
    $sql = "SELECT contrasena FROM usuarios WHERE nickname = '$nickname'"; 
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $contrasena_guardada=$row["contrasena"];

    // Verificar la contraseña
    if (password_verify($contrasena, $contrasena_guardada)) {
        echo "Inicio de sesión exitoso";
        $_SESSION['nickname'] = $nickname; 
    } else {
        echo "Error: Usuario o contraseña incorrectos";
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
    <title>Iniciar Sesión</title>
</head>
<body>
    <header>
        <h1>ASIX Projecte</h1>
        <nav class="top-nav">
            <div class="menu-container">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
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

    <section class="login-section">
        <div class="login-container">
            <h2>Inicie Sesión</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="nickname">Nombre de Usuario:</label>
                <input type="text" id="nickname" name="nickname" required>

                <label for="contrasena">Contraseña:</label>
                <input type="contrasena" id="contrasena" name="contrasena" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </section>

    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
