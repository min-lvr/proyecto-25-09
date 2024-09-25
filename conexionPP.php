<?php

$host = 'localhost'; // Cambia esto si tu servidor de base de datos está en otro host
$usuario = 'root'; // Cambia esto según tu configuración
$contraseña = ''; // Cambia esto según tu configuración
$base_de_datos = 'login_registro_db'; // Cambia esto según tu configuración

// Crear la conexión
$mysqli = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar la conexión
if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}
?>