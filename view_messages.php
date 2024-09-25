<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "login_registro_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los mensajes
$sql = "SELECT nombre, correo, mensaje, created_at FROM contacto ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Mensajes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Mensaje</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar los mensajes
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";

                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["correo"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["mensaje"]) . "</td>";
                    echo "<td>" . $row["created_at"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron mensajes.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>