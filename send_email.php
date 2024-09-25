<?php

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


$to = 'garzonmariansofia@gmail.com'; // Reemplaza con tu dirección de correo
$subject = 'Nuevo mensaje de contacto';
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$mensaje = $_POST['mensaje'];

$headers = "From: $correo";

$correo_mensaje = "Nombre: $nombre\n";
$correo_mensaje .= "Correo: $correo\n\n";
$correo_mensaje .= "Mensaje:\n$mensaje";

// Insertar en la base de datos
$stmt = $conn->prepare("INSERT INTO contacto (nombre, correo, mensaje) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $correo, $mensaje);

if ($stmt->execute() && mail($to, $subject, $correo_mensaje, $headers)) {
    echo 'Mensaje enviado con éxito.';
} else {
    echo 'Error al enviar el mensaje o guardar en la base de datos.';
}

$stmt->close();
$conn->close();
?>