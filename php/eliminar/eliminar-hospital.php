<?php
session_start();
include('../conexion.php');
$conexion = conexion();

$mensaje = '';
$tipo_mensaje = ''; // 'exito' o 'error'

// Desactivar los reportes de errores para no mostrar detalles en el navegador
mysqli_report(MYSQLI_REPORT_OFF); // Esto desactiva la visualización de errores en MySQL

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_hospital'])) {
    $nombre_hospital = $_POST['nombre_hospital'];

    // Preparar la llamada al procedimiento almacenado Eliminar_Hospital
    $sql = "CALL Eliminar_Hospital(?)";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro (nombre del hospital)
        $stmt->bind_param("s", $nombre_hospital);

        // Ejecutar el procedimiento almacenado
        if ($stmt->execute()) {
            // Obtener el mensaje de retorno del procedimiento almacenado
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $mensaje = $row['Mensaje'];
                $tipo_mensaje = ($mensaje === 'Hospital eliminado correctamente') ? 'exito' : 'error';
            } else {
                $mensaje = 'No se recibió respuesta de la función.';
                $tipo_mensaje = 'error';
            }
        } else {
            // Si la ejecución falla, manejar el error
            if ($conexion->errno == 1451) { // Código de error para clave foránea
                $mensaje = 'No se puede eliminar el hospital porque tiene departamentos asociados.';
                $tipo_mensaje = 'error';
            } else {
                $mensaje = 'Error al ejecutar la consulta. El hospital contiene departamentos con médicos.';
                $tipo_mensaje = 'error';
            }
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        // Si hay un error al preparar la consulta, mostrar el error detallado
        $mensaje = 'Error al preparar la consulta. Por favor, intente nuevamente.';
        $tipo_mensaje = 'error';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <title>HospiHub - Eliminar Hospital</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/registro.css">
    <style>
        .mensaje-exito {
            color: #2e7d32;
            background-color: #e8f5e9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
            border-left: 5px solid #2e7d32;
        }

        .mensaje-error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
            border-left: 5px solid #d32f2f;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-eliminar {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-eliminar:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Eliminar Hospital</h1>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje-<?php echo $tipo_mensaje; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="formulario">
        <div class="form-group">
            <label for="nombre_hospital">Nombre del hospital a eliminar:</label>
            <input type="text" name="nombre_hospital" id="nombre_hospital" required>
        </div>
        <button type="submit" class="btn-eliminar">Eliminar Hospital</button>
    </form>
</div>

<a href="../menu-admin.php" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>

</body>
</html>
