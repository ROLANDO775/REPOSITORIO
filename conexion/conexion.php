<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "alcaldia";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
?>
