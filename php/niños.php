<?php
session_start(); // Iniciar la sesión
include '../conexion/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre_papa = $_POST['nombre'];
    $nombre_mama = $_POST['apellido_mama'];
    $nombre_nino = $_POST['apellido_nino'];
    $telefono = $_POST['telefono'];

    // Manejo de las imágenes
    $file_renap = $_FILES['foto_renap']['name'];
    $file_tmp_renap = $_FILES['foto_renap']['tmp_name'];
    $file_path_renap = "../niños/" . basename($file_renap);

    $file_pago = $_FILES['foto_pago']['name'];
    $file_tmp_pago = $_FILES['foto_pago']['tmp_name'];
    $file_path_pago = "../niños/" . basename($file_pago);

    // Mover los archivos subidos a la carpeta
    if (move_uploaded_file($file_tmp_renap, $file_path_renap) && 
        move_uploaded_file($file_tmp_pago, $file_path_pago)) {

        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO ninos (nombre_papa, nombre_mama, nombre_nino, telefono, imagen_renap, imagen_pago) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre_papa, $nombre_mama, $nombre_nino, $telefono, $file_path_renap, $file_path_pago);

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción De Niños</title>
    <link rel="stylesheet" href="../css/niños.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h1>Inscripción de Niños Recién Nacidos</h1>
        <p>Ingrese los Datos</p>

        <div class="input-tex">
            <input type="text" name="nombre" placeholder="Nombre del Papá" required>
            <img class="input-icono" src="../image/nombre.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="text" name="apellido_mama" placeholder="Nombre de la Mamá" required>
            <img class="input-icono" src="../image/nombre.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="text" name="apellido_nino" placeholder="Nombre del Niño o Niña" required>
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
            <label for="foto_renap">Certificado De Renap</label>
            <input type="file" id="foto_renap" name="foto_renap" accept=".jpg,.jpeg,.png,.gif" required>
        </div>

        <div class="input-tex">
            <label for="foto_pago">Boleta de Pago</label>
            <input type="file" id="foto_pago" name="foto_pago" accept=".jpg,.jpeg,.png,.gif" required>
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
