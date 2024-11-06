<?php
session_start();

// Deshabilitar el almacenamiento en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['admin'])) {
    header("Location: ../php/inicio.php");
    exit();
}

// Cerrar sesión
if (isset($_POST['logout'])) {
    session_destroy(); 
    header("Location: ../index.php"); // Redirigir a la página de inicio
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: center; 
        }

        /* Estilo del encabezado */
        header {
            background-color: #442889;
            color: white;
            padding: 10px; 
            border-radius: 8px 8px 0 0; 
            margin: 0 10px; 
        }

        header h1 {
            margin: 0;
            font-size: 20px; 
        }

        /* Estilos de navegación */
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap; 
            justify-content: center; 
        }

        nav ul li {
            margin: 0 5px; 
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px; 
            padding: 5px 10px; 
            display: inline-block; 
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Estilos del contenido principal */
        main {
            padding: 15px; 
            max-width: 90%; 
            margin: 20px auto; 
            background-color: white;
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block; 
            margin: 20px 10px; 
        }

        /* Estilo de la imagen */
        .logo {
            max-width: 300px; 
            margin: 20px auto; 
        }

        /* Estilos del botón de cerrar sesión */
        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 15px; 
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px; 
            transition: background-color 0.3s;
            width: 100%; 
            margin-top: 10px; 
        }

        .logout-button:hover {
            background-color:  #c62828;
        }

        /* Estilo del pie de página */
        footer {
            padding: 10px 0;
            color: #333; 
            margin-top: 20px; 
            font-size: 12px; 
        }

    </style>
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="crear_adminis.php">Crear Cuenta</a></li>
                <li><a href="ver_barrios.php">Registros</a></li>
                <li><a href="ver_ninos.php">Inscripciones</a></li>
                <li><a href="ver_multas.php">Multas</a></li>
                <li><a href="ver_difuntos.php">Difunciones</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenido al Panel de Administración</h2>
        <img src="../image/alcaldia.png" alt="Logo" class="logo">
        <p>Utiliza el menú de navegación para la administración.</p>
        
        <form method="post">
            <button type="submit" name="logout" class="logout-button">Cerrar Sesión</button>
        </form>
    </main>

    <footer>
        <p>Administración © 2024</p>
    </footer>
</body>
</html>






