<?php
// Recoger los datos del formulario
include 'conexion.php';
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$mensaje = $_POST['mensaje'];

// Definir el correo electrónico del destinatario
$to = 'garzonmariansofia@gmail.com'; // Cambia esto por la dirección de correo del destinatario
$subject = 'Nuevo mensaje de contacto';
$headers = "From: $correo\r\n";
$headers .= "Reply-To: $correo\r\n";

// Crear el contenido del correo
$body = "Nombre: $nombre\n";
$body .= "Correo electrónico: $correo\n";
$body .= "Mensaje:\n$mensaje\n";

// Enviar el correo
if (mail($to, $subject, $body, $headers)) {
    echo "El mensaje ha sido enviado exitosamente.";
} else {
    echo "Hubo un error al enviar el mensaje.";
}
?>
