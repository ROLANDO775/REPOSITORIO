<?php
session_start(); // Iniciar la sesión
include '../conexion/conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['admin'])) {
    header("Location: ../php/inicio.php");
    exit();
}

// Consulta para obtener todos los usuarios
$sql = "SELECT id, usuario, contraseña FROM admin ORDER BY id";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
} else {
    $usuarios = [];
}

// Manejar la eliminación del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Preparar la consulta para eliminar el usuario
    $deleteSql = "DELETE FROM admin WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $_SESSION['message'] = "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Usuario eliminado con éxito',
                                        confirmButtonText: 'Aceptar'
                                    });
                                 </script>";
    } else {
        $_SESSION['message'] = "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error al eliminar el usuario: " . $stmt->error . "',
                                        confirmButtonText: 'Aceptar'
                                    });
                                 </script>";
    }

    // Cerrar la declaración
    $stmt->close();

    // Redirigir para evitar el reenvío del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Cerrar conexión
$conn->close();

// Mensaje desde la sesión
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            color: #333;
        }
        header {
            background: #442889;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 20px; 
        }
        header img {
            height: 50px; 
            margin-right: 10px; 
        }
        header h1 {
            margin: 0; 
            font-size: 24px; 
        }
        .nav-links {
            margin-top: 10px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 25px; 
            padding: 5px; 
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .user-table th,
        .user-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .user-table th {
            background-color: #4cae4c;
            color: white;
        }
        .user-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .user-table tr:hover {
            background-color: #e0e0e0;
        }
        .delete-button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
        .success {
            color: green;
            text-align: center;
            margin: 15px 0;
            font-weight: bold;
        }
        .error {
            color: red;
            text-align: center;
            margin: 15px 0;
            font-weight: bold;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<header>
    <img src="../image/alcaldia.png" alt="Logo">
    <h1>Cuenta de Administradores</h1>
    <nav class="nav-links">
        <a href="admin.php">Inicio</a>
    </nav>
</header>

<main>
    <?php if ($message) echo $message; ?>
    
    <?php if (count($usuarios) > 0): ?>
        <table class='user-table'>
            <tr>
                <th>Número</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($usuarios as $index => $usuario): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['contraseña']); ?></td>
                    <td>
                        <form method='post' action='' class='delete-form'>
                            <input type='hidden' name='id' value='<?php echo $usuario['id']; ?>'>
                            <button type='button' class='delete-button' onclick='confirmDelete(this)'>Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class='error'>No hay usuarios registrados.</p>
    <?php endif; ?>
</main>

<script>
function confirmDelete(button) {
    const form = button.closest('.delete-form');
    const userId = form.querySelector('input[name="id"]').value;

    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás recuperar este usuario después de eliminarlo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#442889',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'delete');
            hiddenInput.setAttribute('value', true);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
}
</script>

</body>
</html>
