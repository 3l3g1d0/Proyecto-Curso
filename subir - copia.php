<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado. <a href='conexion_login.php'>Volver al login</a>";
    exit();
}
?>
<?php
if (isset($_SESSION['nickname'])) {
   
    $servername = "127.0.0.1";
    $username = "admin";
    $password = "admin";
    $dbname = "usuarios";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el ID del usuario basado en el nickname
    $nickname = $_SESSION['nickname'];
    $sql = "SELECT id FROM usuarios WHERE nombre = '".$nickname."'";
    $result = $conn->query($sql);
    
    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Guardar el ID del usuario en una variable de sesión
        $_SESSION['id_usuario'] = $row["id"];
        // Mostrar el ID del usuario por pantalla
        //echo "ID de usuario: " . $row['id'];
    } else {
        echo "Usuario no encontrado.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    if (isset($_SESSION['id_usuario'])) {
        $idUsuario = $_SESSION['id_usuario'];

        $servername = "127.0.0.1";
        $username = "admin";
        $password = "admin";
        $dbname = "usuarios";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        if (is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $nombreDirectorio="C:\Users\cf2022336\Downloads\laragon\www";
            $nombreFichero = $_FILES['imagen']['name'];
            $fileSize = $_FILES['imagen']['size'];
            $fileExtension = pathinfo($nombreFichero, PATHINFO_EXTENSION);
            move_uploaded_file ($_FILES['imagen']['tmp_name'],
                $nombreDirectorio . "\archivos\\" . $nombreFichero); 
            
            $sql = "INSERT INTO archivos (nombre_archivo, tamaño, extension, idUsuario) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("sisi", $nombreFichero, $fileSize, $fileExtension, $idUsuario);
        
            if ($stmt->execute() === TRUE) {
                echo "El archivo se ha subido correctamente.";
            } else {
                echo "Error al subir el archivo: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "No se ha podido subir el archivo\n";
        }

    } else {
        echo "ID de usuario no encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Subir Archivos</title>
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
            if (isset($_SESSION['nickname'])) {
                echo '<div class="user-info">' . $_SESSION['nickname'] . '</div>';
            }
            ?>
        </nav>
    </header>

    <!-- CASILLA ARCHIVO ------------------------------------------------------------------------------------------------------>
    <section class="upload-section">
        <div class="upload-column">
            <div class="start-box">
                <p>Subir Archivo</p>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="imagen" id="imagen">
                    <button type="submit" class="start-button" name="submit">Subir</button>
                </form>
            </div>
        </div>
    </section>
    
    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
