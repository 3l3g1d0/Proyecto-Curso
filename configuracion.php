<?php
session_start();

if (!isset($_SESSION['nickname'])) {
    echo "Acceso denegado. <a href='admin.php'>Volver al inicio de sesión</a>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start; height: 100vh; margin: 0;">
    <div>
        <h1>Panel Configuración Administrador</h1>
        <table>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Editar</th>
            </tr>
            <?php
           
            $servername = "127.0.0.1";
            $username = "admin";
            $password = "admin";
            $dbname = "usuarios";
           
            $conn = new mysqli($servername, $username, $password, $dbname);
           
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
           
            
            $sql = "SELECT id, nombre, departamento FROM usuarios";
            $result = $conn->query($sql);
           
            if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nombre"] . "</td><td>" . $row["departamento"] . "</td><td><button><a href='#' onclick=\"editUserDepartment(" . $row["id"] . ")\">Editar</a></button></td></tr>";
                }
            } else {
                echo "0 resultados";
            }
            $conn->close();
            ?>
        </table>

        <h3>Editar Departamento de Usuario</h3>
        <?php
        if(isset($_POST['userid']) && isset($_POST['department'])) {
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            $userId = $_POST['userid'];
            $newDepartment = $_POST['department'];
            $updateSql = "UPDATE usuarios SET departamento='$newDepartment' WHERE id='$userId'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Departamento actualizado con éxito.";
            } else {
                echo "Error al actualizar el departamento: " . $conn->error;
            }
            $conn->close();
        }
        ?>
        <form method="post">
            <label for="userid">ID de Usuario:</label>
            <input type="text" id="userid" name="userid"><br><br>
            <label for="department">Nuevo Departamento:</label>
            <input type="text" id="department" name="department"><br><br>
            <input type="submit" value="Editar">
        </form>
    </div>

    <script>
        function editUserDepartment(userId) {
            document.getElementById("userid").value = userId;
        }
    </script>
</body>
</html>
