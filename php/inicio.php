<?php
session_start();
$mensaje_error = '';

// Redirigir si el usuario ya ha iniciado sesión
if (isset($_SESSION['admin'])) {
    header("Location: ../admin/admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir la conexión a la base de datos
    include '../conexion/conexion.php'; 

    // Obtener datos del formulario
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']);

    // Consulta a la base de datos
    $sql = "SELECT * FROM admin WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verificar si la contraseña coincide
        $row = $result->fetch_assoc();
        if ($contraseña === $row['contraseña']) {
            // Almacenar el nombre de usuario en la sesión
            $_SESSION['admin'] = $usuario; // Establecer variable de sesión
            // Redirigir al usuario a la administración
            header("Location: ../admin/admin.php");
            exit();
        } else {
            $mensaje_error = "Contraseña incorrecta";
        }
    } else {
        $mensaje_error = "Usuario no encontrado";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/inicio.css">
</head>
<body>

    <form action="" method="post">
        <h2>Administrador</h2>
        
        <?php
        if (!empty($mensaje_error)) {
            echo '<p style="color:red;">' . $mensaje_error . '</p>';
        }
        ?>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br><br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>






