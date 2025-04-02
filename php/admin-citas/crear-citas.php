<!DOCTYPE html>
<html lang="es">
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>HospiHub - Crear todas las citas</title>
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <meta name="designer" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/ver.css">
    <style>
        .success-message {
            color: #4CAF50;
            text-align: center;
            font-size: 1.5em;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 5px solid #4CAF50;
        }
        .error-message {
            color: #f44336;
            text-align: center;
            font-size: 1.5em;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 5px solid #f44336;
        }
    </style>
</head>
<body>

<nav>
    <div id="logo">HospiHub</div>
</nav>

<div id="contenedor">
    <h1>Crear todas las citas anuales</h1>
    <?php
    session_start();
    
    include('../conexion.php');
    $conexion = conexion();

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Ejecutar el procedimiento almacenado
    if ($conexion->multi_query("CALL Crear_Citas()")) {
        // Obtener todos los resultados
        do {
            if ($result = $conexion->store_result()) {
                while ($row = $result->fetch_assoc()) {
                    if (isset($row['Resultado'])) {
                        echo "<div class='success-message'>" . htmlspecialchars($row['Resultado']) . "</div>";
                    } elseif (isset($row['mensaje_error'])) {
                        echo "<div class='error-message'>" . htmlspecialchars($row['mensaje_error']) . "</div>";
                    }
                }
                $result->free();
            }
        } while ($conexion->more_results() && $conexion->next_result());
    } else {
        echo "<div class='error-message'>Error al crear las citas: " . htmlspecialchars($conexion->error) . "</div>";
    }

    // Cerrar la conexión
    $conexion->close();
    ?>
</div>

<a href="../menu-admin.php" id="volver">Volver al menú del admin <span class="material-symbols-outlined">home</span></a>

</body>
</html>