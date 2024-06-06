<?php
$servername = "localhost";
$username = "root"; // Por defecto en XAMPP el usuario es 'root'
$password = "";     // Por defecto en XAMPP no hay contraseña
$dbname = "sabor_tostado"; // Cambia esto al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
