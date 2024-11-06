<?php
session_start(); // Iniciar la sesión
include '../conexion/conexion.php'; 

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['admin'])) {
    header("Location: ../php/inicio.php");
    exit();
}

// Manejo de mensajes
$message = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Primero obtenemos el nombre del archivo de la imagen
    $sql = "SELECT imagen FROM multas WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagen = $row['imagen'];

        // Consulta para eliminar el registro de la base de datos
        $sql = "DELETE FROM multas WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Eliminar la imagen del servidor
            $rutaImagen = "../pagos/" . $imagen;
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
            $_SESSION['message'] = "Registro eliminado correctamente.";
        } else {
            $_SESSION['message'] = "Error al eliminar el registro: " . $stmt->error;
        }
    } else {
        $_SESSION['message'] = "Registro no encontrado.";
    }
    $stmt->close();

    // Redirigir a la misma página para evitar la re-ejecución del script
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Consulta para obtener todos los registros de la tabla multas
$sql = "SELECT * FROM multas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pago de Multas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 20px;
            padding-top: 80px; /* Espacio para el encabezado fijo */
        }

        /* Estilos para el encabezado */
        .header {
            display: flex;
            align-items: center;
            background-color: #442889; /* Color del encabezado */
            padding: 10px 20px;
            color: white;
            position: fixed;
            top: 0;
            left: 0; /* Alinear a la izquierda */
            width: 100%;
            z-index: 1000;
            box-sizing: border-box;
        }

        .header img {
            width: 70px;
            margin-right: 20px;
        }

        .header h1 {
            margin: 0;
            flex-grow: 1;
            text-align: left;
            font-size: 1.5em;
        }

        .nav-links {
            margin-left: auto;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 20px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        h2 {
            text-align: center;
        }

        /* Estilos para la tabla */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        .styled-table thead tr {
            background-color: #4CAF50;
            color: white;
        }

        .styled-table th, .styled-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .styled-table tbody tr {
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .styled-table tbody tr:hover {
            background-color: #f2f2f2;
        }

        /* Estilos para el botón de eliminar */
        .delete-button {
            color: white;
            background-color: #f44336;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete-button:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<div class="header">
    <img src="../image/alcaldia.png" alt="Logo">
    <h1>Listado de Pago de Multas</h1>
    <div class="nav-links">
        <a href="admin.php">Inicio</a>
        <a href="ver_barrios.php">Registros</a>
        <a href="ver_ninos.php">Inscripciones</a>
        <a href="ver_difuntos.php">Difunciones</a>
    </div>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Éxito!',
                text: '<?php echo addslashes($_SESSION['message']); ?>',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    <?php unset($_SESSION['message']); // Limpiar el mensaje ?>
<?php endif; ?>

<?php
if ($result->num_rows > 0) {
    echo "<h2>Listado de Pago de Multas Registrados</h2>";
    echo "<table class='styled-table'>
            <thead>
                <tr>
                    <th>Cod</th> <!-- Cambiado de ID a Cod -->
                    <th>Nombre</th>
                    <th>Motivo</th>
                    <th>Teléfono</th>
                    <th>Boleta de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>";

    // Mostrar cada registro en una fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td> <!-- Sigue mostrando el ID -->
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['motivo'] . "</td>
                <td>" . $row['telefono'] . "</td>
                <td><a href='../pagos/" . $row['imagen'] . "' class='thumbnail' target='_blank'><img src='../pagos/" . $row['imagen'] . "' alt='Imagen de la multa' width='130'></a></td>
                <td>
                    <a href='#' class='delete-button' onclick='confirmDelete(" . $row['id'] . ")'>Eliminar</a>
                </td>
            </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No hay registros.";
}

// Cerrar la conexión
$conn->close();
?>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#442889',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a la misma página con el ID para eliminar
            window.location.href = '?id=' + id;
        }
    });
}
</script>

</body>
</html>
