<?php
session_start();
include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barrio = $_POST['barrio'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $servicio = $_POST['servicio'];
    $ubicacion = $_POST['ubicacion'];
    $telefono = $_POST['telefono'];
    $codigo = $_POST['codigo'];

    if ($codigo !== "2024210") {
        $_SESSION['message'] = "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Código incorrecto',
                                        text: 'El código ingresado es incorrecto.',
                                        confirmButtonText: 'Aceptar'
                                    });
                                    </script>";
    } else {
        // Consulta para insertar los datos en la base de datos
        $sql = "INSERT INTO barrios (barrio, nombre, apellido, servicio, ubicacion, telefono)
                VALUES ('$barrio', '$nombre', '$apellido', '$servicio', '$ubicacion', '$telefono')";

        if ($conn->query($sql) === TRUE) {
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
                                            text: 'No se pudo registrar: " . $conn->error . "',
                                            confirmButtonText: 'Aceptar'
                                        });
                                        </script>";
        }

        // Redirigir para evitar el reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $conn->close();
}

// Mensaje desde la sesión
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/registro.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validateForm(event) {
            const codigoInput = document.querySelector('input[name="codigo"]');
            const requiredCodigo = "2024210"; // código requerido

            if (codigoInput.value !== requiredCodigo) {
                event.preventDefault(); // Evita el envío del formulario
                Swal.fire({
                    icon: 'error',
                    title: 'Código incorrecto',
                    text: 'El código ingresado es incorrecto.',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="validateForm(event)">
        <h1>Registro de Barrios</h1>
        <p>Ingrese los Datos</p>

        <div class="input-tex">
            <select name="barrio" id="barrio" required>
                <option value="">Seleccione su barrio</option>
                <?php
                // Obtener barrios de la base de datos
                $sql = "SELECT nombre FROM lista_barrios";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay barrios disponibles</option>";
                }
                ?>
            </select>
        </div>

        <div class="input-tex">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <img class="input-icono" src="../image/nombre.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="text" name="apellido" placeholder="Apellidos" required>
            <img class="input-icono" src="../image/nombre.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="text" name="servicio" placeholder="Servicios">
        </div>

        <div class="input-tex">
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <img class="input-icono" src="../image/direccion.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="text" name="telefono" placeholder="Teléfono" pattern="^([0-9]{8})$" title="Por favor, ingrese un número de teléfono de 8 dígitos." oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <img class="input-icono" src="../image/telefono.svg" alt="">
        </div>

        <div class="input-tex">
            <input type="password" name="codigo" placeholder="Código" required>
            <img class="input-icono" src="../image/contraseña.svg" alt="">
        </div>

        <div class="button-group">
            <button type="submit">Registrar</button>
            <a href="../index.php" class="cancel-button">Cancelar</a>
        </div>
    </form>

    <!-- Mensaje desde la sesión -->
    <?php if ($message) echo $message; ?>
</body>
</html>




