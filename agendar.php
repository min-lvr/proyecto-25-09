<?php
header('Content-Type: application/json');

include 'conexion.php'; // Asegúrate de que el archivo conexion.php está configurado correctamente

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$fechaHora = $fecha . ' ' . $hora;

// Verificar si ya hay una cita para esta fecha y hora
$sql_check = "SELECT COUNT(*) AS count FROM citas WHERE fecha = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param('s', $fechaHora);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row = $result_check->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'La hora ya está reservada.']);
} else {
    // Preparar y ejecutar la consulta de inserción
    $sql_insert = "INSERT INTO citas (nombre, correo, fecha) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('sss', $nombre, $correo, $fechaHora);

    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cita agendada con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agendar la cita: ' . $stmt_insert->error]);
    }
}

// Cerrar conexiones
$stmt_check->close();
$stmt_insert->close();
$conn->close();
?>

