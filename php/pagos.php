<?php
// pagos.php
session_start(); // Iniciar la sesión
include '../conexion/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $motivo = $_POST['motivo'];
    $telefono = $_POST['telefono'];

    // Manejar la subida de la imagen
    $targetDir = "../pagos/"; 
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);

    // Mover el archivo subido a la carpeta
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $imagen = basename($_FILES["file"]["name"]);

        $stmt = $conn->prepare("INSERT INTO multas (nombre, motivo, telefono, imagen) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $motivo, $telefono, $imagen);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $_SESSION['message'] = "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Registro exitoso',
                                            text: 'Los datos han sido registrados correctamente.',
                                            confirmButtonText: 'Aceptar'
                                        });
                                     </script>";
        } else {
            $_SESSION['message'] = "<script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'No se pudo registrar: " . $stmt->error . "',
                                            confirmButtonText: 'Aceptar'
                                        });
                                     </script>";
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        $_SESSION['message'] = "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Lo siento, hubo un error al subir tu archivo.',
                                        confirmButtonText: 'Aceptar'
                                    });
                                 </script>";
    }

    // Redirigir para evitar el reenvío del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Cerrar la conexión
$conn->close();

// Mensaje desde la sesión
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
    <link rel="stylesheet" href="../css/pagos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h1>Pago de Multas</h1>
        <p>Ingrese los Datos</p>

        <div class="input-tex">
            <input type="text" name="nombre" placeholder="Nombre Completo" required>
            <img class="input-icono" src="../image/nombre.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="text" name="motivo" placeholder="Motivo de pago" required>
        </div>

        <div class="input-tex">
            <input 
                type="text" 
                name="telefono" 
                placeholder="Teléfono" 
                required 
                pattern="^([0-9]{8})$" 
                title="Por favor, ingrese un número de teléfono de 8 dígitos."
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
            >
            <img class="input-icono" src="../image/telefono.svg" alt="">
        </div>

        <div class="input-tex">
            <label for="file">Boleta de Pago</label>
            <input type="file" id="file" name="file" accept=".jpg,.jpeg,.png,.gif" required>
        </div>

        <div class="button-group">
            <button type="submit">Registrar</button>
            <a href="../index.php" class="cancel-button">Cancelar</a>
        </div>
    </form>

    <!-- Incluir el script de SweetAlert si hay un mensaje -->
    <?php if ($message) echo $message; ?>
</body>
</html>



