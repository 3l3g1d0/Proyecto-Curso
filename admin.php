<?php
session_start(); // Iniciar la sesión

$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "administradores";

// Crear la conexión
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Procesar datos del formulario 
$nickname = $_POST['nickname']; // Cambiado de $_REQUEST a $_POST
$contrasena = $_POST['contrasena']; // Cambiado de $_REQUEST a $_POST

// Consulta preparada para obtener la contraseña almacenada en la base de datos
$sql = "SELECT contrasena FROM usuarios WHERE nickname = '$nickname'"; 
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$contrasena_guardada=$row["contrasena"];

// Verificar la contraseña
if (password_verify($contrasena, $contrasena_guardada)) {
    echo "Inicio de sesión exitoso";
    $_SESSION['nickname'] = $nickname; // Almacena el nombre de usuario en la sesión
    header("Location: configuracion.php"); // Redirigir al usuario a la página de configuración
} else {
    echo "Error: Usuario o contraseña incorrectos";
}


$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Iniciar Sesión como administrador</title>
</head>
<body>
    <header>
        <h1>Panel administrativo administrador</h1>
        <nav class="top-nav">
            <?php
            // Muestra el nombre de usuario si está presente en la sesión
            if (isset($_SESSION['nickname'])) {
                echo '<div class="user-info">' . $_SESSION['nickname'] . '</div>';
            }
            ?>
            <div class="menu-container">
                <ul>
                </ul>
            </div>
           
        </nav>
    </header>

    <section class="login-section">
        <div class="login-container">
            <h2>Inicie Sesión como administrador</h2>
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