<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado. <a href='conexion_login.php'>Volver al login</a>";
    exit();
}
?>
<?php
// Detecta el sistema operativo
if (stripos(PHP_OS, 'WIN') === 0) {
    // Ruta para Windows
    $ruta_archivo = 'file:///C:/laragon/www/archivos/' . $row["nombre_archivo"];
} else {
    // Ruta para Linux
    $ruta_archivo = 'file:///var/www/archivos/' . $row["nombre_archivo"];
}
?>
<?php
if (isset($_SESSION['nickname'])) {
   
    include "conexion.php";
    // Obtener el ID del usuario basado en el nickname
    $nickname = $_SESSION['nickname'];
    $sql = "SELECT id FROM usuarios WHERE nombre = '".$nickname."'";
    $result = $mysqli->query($sql);
    
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['compartir'])) {
    $idUsuarioCompartir = $_POST['idUsuario'];
    $nombreArchivo = $_POST['nombre_archivo'];
    $fileSize = $_POST["tamaño"];
    $tipoArchivo = $_POST["extension"];

    $sql = "INSERT INTO archivos (nombre_archivo, tamaño, extension, idUsuario) VALUES (?, ?, ?, ?)";
    //echo $sql;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sisi", $nombreArchivo, $fileSize, $tipoArchivo, $idUsuarioCompartir);

    if ($stmt->execute()) {
        echo "Archivo compartido exitosamente.";
    } else {
        echo "Error al compartir el archivo: " . $stmt->error;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $id_archivo = $_POST['id_archivo'];

    $sql = "DELETE FROM archivos WHERE id_archivo = ".$id_archivo;
    //echo $sql;
    $stmt = $mysqli->prepare($sql);

    if ($stmt->execute()) {
        echo "Archivo eliminado exitosamente.";
    } else {
        echo "Error al elminar el archivo: " . $stmt->error;
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
    <link rel="stylesheet" href="styles4.css">
</head>
<body>
<header>
<?php
                if (isset($_SESSION['nickname'])) {
                    echo '<div class="user-info">Bienvenido: ' . $_SESSION['nickname'] . '</div>';
                }
            ?>

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
    <section class="container">
        <div class="container">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
                    if (isset($_SESSION['id_usuario'])) {
                        $idUsuario = $_SESSION['id_usuario'];
                /*
                        $servername = "127.0.0.1";
                        $username = "root";
                        $password = "";
                        $dbname = "usuarios";
                
                        $conn = new mysqli($servername, $username, $password, $dbname);
                
                        if ($mysqli->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }
                  */      
                        // Consulta SQL para seleccionar todos los archivos del usuario actual
                        $sql = "SELECT id_archivo, nombre_archivo, tamaño, extension FROM archivos WHERE idUsuario = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("i", $idUsuario);
                        $stmt->execute();
                        $result = $stmt->get_result();
                
                         // Mostrar los resultados
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>";
                                //echo "id".$row["id_archivo"] . "<br>";
                                echo "Nombre de archivo: " . $row["nombre_archivo"] . "<br>";
                                echo "Tamaño: " . $row["tamaño"] . "<br>";
                                echo "Extensión: " . $row["extension"] . "<br>";
                
                                // Botón Descargar------------------------------------------------------------------------------------------------------------
                                echo "<button style='display: inline-block;'>
                                        <a target='blank' href='<?php echo $ruta_archivo; ?>'>Descargar</a>
                                        </button>";
                                
                                // Botón Compartir------------------------------------------------------------------------------------------------------------
                                echo '
                                <form method="post" action="mis-archivos.php" style="display: inline-block;">
                                    <label for="idUsuario">Ingrese ID de Usuario:</label>
                                    <input type="hidden" name="nombre_archivo" value="' . $row["nombre_archivo"] . '">
                                    <input type="hidden" name="tamaño" value="' . $row["tamaño"] . '">
                                    <input type="hidden" name="extension" value="' . $row["extension"] . '">
                                    <input type="text" id="idUsuario" name="idUsuario">
                                    <button type="submit" name="compartir">Compartir</button>
                                </form>';
                
                                // Botón Eliminar------------------------------------------------------------------------------------------------------------
                                echo '
                                <form method="post" action="mis-archivos.php" style="display: inline-block;">
                                    <input type="hidden" name="id_archivo" value="'. $row["id_archivo"] . '">
                                    <button type="submit" name="eliminar">Eliminar</button>
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
            ?>
        </div>
    </section>
    <footer>
        <p class="small">ProyectoSintesis &copy; 2023. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
