<?php
session_start();
include '../conexion/conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['admin'])) {
    header("Location: ../php/inicio.php");
    exit();
}

// Variables
$barrioSeleccionado = '';
$resultado = [];
$searchTerm = '';

// Muestra el barrio seleccionado de la sesión
if (isset($_SESSION['barrioSeleccionado'])) {
    $barrioSeleccionado = $_SESSION['barrioSeleccionado'];
}

// Manejo de la selección de barrio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['barrio'])) {
    $barrioSeleccionado = $_POST['barrio'];
    $_SESSION['barrioSeleccionado'] = $barrioSeleccionado; // Guardar en sesión
}

// Manejo de la búsqueda
if (isset($_POST['search'])) {
    $searchTerm = trim($_POST['search_term']);
}

// Si se está editando, cargar el registro correspondiente
$editarRegistro = null;
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    $editarSql = "SELECT * FROM barrios WHERE id = $id";
    $editarRegistro = $conn->query($editarSql)->fetch_assoc();
    if ($editarRegistro) {
        $barrioSeleccionado = $editarRegistro['barrio']; // Se obtiene el barrio del registro para mostrar en el formulario
    }
}

// Manejo de eliminar registro
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Eliminar el registro
    $deleteSql = "DELETE FROM barrios WHERE id = $id";
    $conn->query($deleteSql);

    // Redirigir a la misma página con el barrio seleccionado
    header("Location: " . $_SERVER['PHP_SELF'] . "?barrio=" . urlencode($barrioSeleccionado));
    exit();
}

// Manejo de editar registro
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nombre = substr(trim($_POST['nombre']), 0, 255);
    $apellido = substr(trim($_POST['apellido']), 0, 255);
    $servicio = substr(trim($_POST['servicio']), 0, 255);
    $ubicacion = substr(trim($_POST['ubicacion']), 0, 255);
    $telefono = $_POST['telefono'];

    $updateSql = "UPDATE barrios SET nombre='$nombre', apellido='$apellido', servicio='$servicio', ubicacion='$ubicacion', telefono='$telefono' WHERE id=$id";
    $conn->query($updateSql);

    // Redirigir a la misma página con el barrio seleccionado
    header("Location: " . $_SERVER['PHP_SELF'] . "?barrio=" . urlencode($barrioSeleccionado));
    exit();
}

// Consultar los registros del barrio seleccionado si se ha seleccionado uno
if (!empty($barrioSeleccionado)) {
    $sql = "SELECT * FROM barrios WHERE barrio = '$barrioSeleccionado'";
    if (!empty($searchTerm)) {
        $sql .= " AND (nombre LIKE '%$searchTerm%' OR apellido LIKE '%$searchTerm%')";
    }
    $resultado = $conn->query($sql);
}

// Obtener la lista de barrios
$sqlBarrios = "SELECT DISTINCT barrio FROM barrios";
$barriosResult = $conn->query($sqlBarrios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Barrios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            background: white;
            padding: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
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
        select, input[type="text"], button {
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="text"] {
            width: 190px;
        }
        button {
            cursor: pointer;
        }
        button[type="submit"] {
            background-color: #442889;
            color: white;
            border: none;
        }
        button[type="submit"]:hover {
            background-color: #5a32a2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        
        /* Estilos para los botones de acción en la tabla */
table a {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 5px;
    border-radius: 4px;
    text-decoration: none;
    color: white;
    font-weight: bold;
}

table a.edit {
    background-color: #442889; 
}

table a.edit:hover {
    background-color: #218838; 
}

table a.delete {
    background-color: #d33;
}

table a.delete:hover {
    background-color: #c82333; 
}

    </style>
</head>
<body>
    <header>
        <div class="header">
            <img src="../image/alcaldia.png" alt="Logo">
            <h1>Registro de Barrios</h1>
            <nav>
                <div class="nav-links">
                    <a href="admin.php">Inicio</a>
                    <a href="ver_ninos.php">Inscripciones</a>
                    <a href="ver_multas.php">Multas</a>
                    <a href="ver_difuntos.php">Difunciones</a>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Visualizar Barrios y Registros</h2>

        <form method="post">
            <h3>Seleccione un Barrio</h3>
            <select name="barrio" id="barrio" required>
                <option value="">Seleccione un barrio</option>
                <?php
                if ($barriosResult->num_rows > 0) {
                    while ($row = $barriosResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['barrio']) . "' " . ($barrioSeleccionado == $row['barrio'] ? 'selected' : '') . ">" . htmlspecialchars($row['barrio']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay barrios disponibles</option>";
                }
                ?>
            </select>
            <button type="submit">Ver Registros</button>
        </form>

        <form method="post" style="margin-top: 20px;">
            <h3>Buscar por Nombre o Apellido</h3>
            <input type="text" name="search_term" placeholder="Ingrese nombre o apellido" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit" name="search">Buscar</button>
            <button type="button" class="btn-danger" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?barrio=<?php echo urlencode($barrioSeleccionado); ?>';">Limpiar Búsqueda</button>
        </form>

        <button onclick="printDiv()" style="margin-top: 20px;">Imprimir Registros</button>

        <div id="printableArea">
            <div class="header">
                <img src="../image/alcaldia.png" alt="Logo">
                <h1>Alcaldía Comunitaria, Aldea San Antonio Sija, San Francisco El Alto, Departamento De Totonicapan</h1>
                <h2>ADMINISTRACIÓN DEL SISTEMA PROPIO DE JUSTICIA</h2>
            </div>

            <?php if (!empty($resultado)): ?>
                <h3>Registros: <?php echo htmlspecialchars($barrioSeleccionado); ?></h3>
                <?php if ($resultado->num_rows > 0): ?>
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Servicio</th>
                            <th>Ubicación</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                        <?php $contador = 1; ?>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $contador++; ?></td>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($row['servicio']); ?></td>
                                <td><?php echo htmlspecialchars($row['ubicacion']); ?></td>
                                <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                <td>
    <a href="?edit_id=<?php echo $row['id']; ?>" class="edit">Editar</a>
    <a href="#" class="delete" onclick="confirmDelete(<?php echo $row['id']; ?>)">Eliminar</a>
</td>

                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No se encontraron registros.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>Seleccione un barrio para ver los registros.</p>
            <?php endif; ?>
        </div>

        <?php if ($editarRegistro): ?>
            <h3>Editar Registro</h3>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $editarRegistro['id']; ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($editarRegistro['nombre']); ?>" required>
                <br>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" value="<?php echo htmlspecialchars($editarRegistro['apellido']); ?>" required>
                <br>
                <label for="servicio">Servicio:</label>
                <input type="text" name="servicio" value="<?php echo htmlspecialchars($editarRegistro['servicio']); ?>" >
                <br>
                <label for="ubicacion">Ubicación:</label>
                <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($editarRegistro['ubicacion']); ?>" required>
                <br>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo htmlspecialchars($editarRegistro['telefono']); ?>" >
                <br>
                <button type="submit" name="edit">Actualizar</button>
            </form>
        <?php endif; ?>

    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#442889',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?delete=' + id;
                }
            });
        }

        function printDiv() {
    var divToPrint = document.getElementById("printableArea");

    // Crear una copia del contenido a imprimir
    var newWin = window.open("", "_blank");
    newWin.document.write('<html><head><title>Imprimir</title>');
    
    // Estilos para la impresión
    newWin.document.write('<style>');
    newWin.document.write('body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }');
    newWin.document.write('.header { display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 30px; }');
    newWin.document.write('.header img { position: absolute; left: 0; top: 65px; height: 85px; }');
    newWin.document.write('.header h1 { font-size: 22px; margin: 0; text-align: center; padding-top: 20px; }');
    newWin.document.write('.header h2 { font-size: 16px; margin-top: 10px; text-align: center; color: #333; }');
    newWin.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    newWin.document.write('table, th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    newWin.document.write('th { background-color: #f2f2f2; }');
    newWin.document.write('td { word-wrap: break-word; max-width: 200px; }');
    newWin.document.write('</style>');
    
    newWin.document.write('</head><body>');
    
    // Cabecera de impresión
    newWin.document.write('<div class="header">');
    newWin.document.write('<img src="../image/alcaldia.png" alt="Logo">');
    newWin.document.write('<h1>Alcaldía Comunitaria, Aldea San Antonio Sija, San Francisco El Alto, Departamento De Totonicapan</h1>');
    newWin.document.write('<h2>ADMINISTRACIÓN DEL SISTEMA PROPIO DE JUSTICIA</h2>');
    newWin.document.write('</div>');
    
    // Incluimos el h3 con el nombre del barrio
    newWin.document.write('<h3>Registros: ' + '<?php echo htmlspecialchars($barrioSeleccionado); ?>' + '</h3>'); 
    
    // Obtener la tabla y filtrar la última columna
    var table = divToPrint.querySelector('table');
    var newTable = table.cloneNode(true); // Clonamos la tabla original
    var rows = newTable.rows;

    for (var i = 0; i < rows.length; i++) {
        rows[i].deleteCell(-1); // Eliminar la última celda de cada fila
    }
    
    newWin.document.write(newTable.outerHTML); // Solo la tabla sin la última columna
    newWin.document.write('</body></html>');
    
    newWin.document.close();
    newWin.focus();
    newWin.print(); // Imprimir en la misma ventana
    newWin.close();
}

    </script>
</body>
</html>
