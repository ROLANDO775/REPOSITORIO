<?php
session_start(); // Iniciar la sesión
include '../conexion/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    // Manejo de las imágenes
    $certificado_file_name = $_FILES['certificado']['name'];
    $certificado_file_tmp = $_FILES['certificado']['tmp_name'];
    $certificado_file_path = "../difuncion/" . basename($certificado_file_name);

    $boleta_file_name = $_FILES['boleta']['name'];
    $boleta_file_tmp = $_FILES['boleta']['tmp_name'];
    $boleta_file_path = "../difuncion/" . basename($boleta_file_name);

    // Mover los archivos subidos a la carpeta
    $certificado_upload = move_uploaded_file($certificado_file_tmp, $certificado_file_path);
    $boleta_upload = move_uploaded_file($boleta_file_tmp, $boleta_file_path);

    if ($certificado_upload && $boleta_upload) {
        // Preparar y ejecutar la inserción
        $stmt = $conn->prepare("INSERT INTO difuntos (nombre, telefono, imagen, imagen_pago) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $telefono, $certificado_file_path, $boleta_file_path);

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
                                        text: 'Error al subir las imágenes.',
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Difuntos</title>
    <link rel="stylesheet" href="../css/difuncion.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h1>Registro de Defunción</h1>
        <p>Ingrese los Datos</p>

        <div class="input-tex">
            <input type="text" name="nombre" placeholder="Nombre Del Difunto" required>
            <img class="input-icono" src="../image/nombre.svg" alt="">
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
            <label for="certificado">Certificado de Defunción</label>
            <input type="file" id="certificado" name="certificado" accept=".jpg,.jpeg,.png,.gif" required>
        </div>

        <div class="input-tex">
            <label for="boleta">Boleta de Pago</label>
            <input type="file" id="boleta" name="boleta" accept=".jpg,.jpeg,.png,.gif" required>
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
