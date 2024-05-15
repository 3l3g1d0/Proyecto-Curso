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
        
        // Consulta SQL para seleccionar todos los archivos del usuario actual
        $sql = "SELECT id_archivo, nombre_archivo, tamaño, extension FROM archivos WHERE idUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

         // Mostrar los resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Nombre de archivo: " . $row["nombre_archivo"] . "<br>";
                echo "Tamaño: " . $row["tamaño"] . "<br>";
                echo "Extensión: " . $row["extension"] . "<br>";

                // Botón Descargar------------------------------------------------------------------------------------------------------------
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    echo "<a target= 'blank' href='file:///C:\Users\cf2022336\Downloads\laragon\www\archivos\\" . $row["nombre_archivo"] . "'>Descargar</a>";
                } else {
                    echo "<a href='C:\Users\cf2022336\Downloads\laragon\www\paginawebproyecto\descargar.php?nombre_archivo=" . $row["nombre_archivo"] . "'><button>Descargar</button></a>";
                }
                
                // Botón Compartir------------------------------------------------------------------------------------------------------------
                echo '
                <form method="post" action="mis-archivos.php">
                    <label for="idUsuario">Ingrese ID de Usuario:</label>
                    <input type="hidden" name="nombre_archivo" value="' . $row["nombre_archivo"] . '">
                    <input type="hidden" name="tamaño" value="' . $row["tamaño"] . '">
                    <input type="hidden" name="extension" value="' . $row["extension"] . '">
                    <input type="text" id="idUsuario" name="idUsuario">
                    <button type="submit" name="compartir">Compartir</button>
                </form>';

                echo "<br><br>";
                
            }
        } else {
            echo "No se encontraron archivos para este usuario.";
        }
        $stmt->close();
    } else {
        echo "ID de usuario no encontrado.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['compartir'])) {
    $idUsuarioCompartir = $_POST['idUsuario'];
    $nombreArchivo = $_POST['nombre_archivo'];
    $fileSize = $_POST["tamaño"];
    $tipoArchivo = $_POST["extension"];

    $sql = "INSERT INTO archivos (nombre_archivo, tamaño, extension, idUsuario) VALUES (?, ?, ?, ?)";
    echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $nombreArchivo, $fileSize, $tipoArchivo, $idUsuarioCompartir);

    if ($stmt->execute()) {
        echo "Archivo compartido exitosamente.";
    } else {
        echo "Error al compartir el archivo: " . $stmt->error;
    }
}
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
        <h1>ASIX Projecte - Mis Archivos</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="subir.php">Subir Archivo</a></li>
               
            </ul>
        </nav>
    </header>
    </header>
    <section class="upload-section">
        <div class="upload-column">
            <div class="start-box">
                <p>Mis archivos</p>
                <form method="post">
                    <input type="hidden" name="submit" value="true">
                    <button type="submit" class="start-button" name="action" value="get_files">Recoger</button>
                </form>
            </div>
        </div>
    </section>
    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>