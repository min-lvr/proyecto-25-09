<?php
// Incluir el archivo de conexión a la base de datos
include 'conexionPP.php';

// Obtener los datos del formulario
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO citas (fecha, hora, nombre, correo) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ssss', $fecha, $hora, $nombre, $correo);

if ($stmt->execute()) {
    echo 'Cita agendada con éxito';
} else {
    echo 'Error al agendar la cita: ' . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>