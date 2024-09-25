<?php
$servername = "localhost";
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "login_registro_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del carrito
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['usuario_id']) || !isset($data['productos'])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit;
}

$usuario_id = $data['usuario_id'];
$productos = $data['productos'];

// Preparar la consulta con la fecha
$stmt = $conn->prepare("INSERT INTO carrito (usuario_id, producto_id, modelo, size, precio, fecha) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($productos as $producto) {
    $producto_id = $producto['producto_id'];
    $modelo = $producto['modelo'];
    $size = $producto['size'];
    $precio = $producto['precio'];
    $fecha = date('Y-m-d H:i:s'); // Fecha actual en formato DATETIME

    $stmt->bind_param("iissds", $usuario_id, $producto_id, $modelo, $size, $precio, $fecha);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(["status" => "success", "message" => "Carrito guardado exitosamente"]);
?>

