<?php
session_start(); // Iniciar la sesión
include '../conexion/conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['admin'])) {
    header("Location: ../php/inicio.php");
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Validar que los campos no estén vacíos
    if (!empty($usuario) && !empty($contraseña)) {
        // Validar la contraseña
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $contraseña)) {
            // Preparar la consulta
            $sql = "INSERT INTO admin (usuario, contraseña) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $usuario, $contraseña);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $_SESSION['message'] = "<script>
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Usuario creado con éxito',
                                                text: 'El nuevo usuario ha sido registrado.',
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
                                            text: 'La contraseña debe contener al menos 8 caracteres, incluyendo letras, números y símbolos.',
                                            confirmButtonText: 'Aceptar'
                                        });
                                     </script>";
        }
    } else {
        $_SESSION['message'] = "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Por favor, complete todos los campos.',
                                        confirmButtonText: 'Aceptar'
                                    });
                                 </script>";
    }

    // Redirigir para evitar el reenvío del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Cerrar conexión
$conn->close();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f0f2f5, #d9e4ef);
            color: #333;
        }
        header {
            background: #442889;
            color: white;
            padding: 10px 0;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
        }
        .header img {
            height: 50px;
            margin-right: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: white;
            display: flex;
            align-items: center;
            flex: 1;
        }
        .nav-links {
            display: flex;
            gap: 15px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        form {
            padding: 39px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%; 
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s;
        }
        form:hover {
            transform: scale(1.02);
        }
        label {
            display: block;
            margin: 35px 0 9px;
            font-weight: bold;
            font-size: 1.1em;
            color: #444;
        }
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
            outline: none;
        }
        input[type="submit"] {
            background-color: #442889;
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 1.1em;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<header>
    <div class="header">
        <img src="../image/alcaldia.png" alt="Logo">
        <h1>Crear Nueva Cuenta de Administrador</h1>
        <nav>
            <div class="nav-links">
                <a href="admin.php">Inicio</a>
                <a href="list_admins.php">Ver Administradores</a>
            </div>
        </nav>
    </div>
</header>

<div class="form-container">
    <form method="post" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <input type="submit" value="Crear Usuario">
    </form>
</div>

<!-- Mostrar mensaje de SweetAlert  -->
<?php if ($message) echo $message; ?>

</body>
</html>
