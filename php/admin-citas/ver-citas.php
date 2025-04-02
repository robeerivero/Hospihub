<!DOCTYPE html>
<html lang="es">
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>HospiHub - Tus Citas</title>
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
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            margin: 2px;
        }
        .cancel-btn {
            background-color: #f44336;
            color: white;
        }
        .cancel-btn:hover {
            background-color: #d32f2f;
        }
        .reschedule-btn {
            background-color: #ff9800;
            color: white;
        }
        .reschedule-btn:hover {
            background-color: #e68a00;
        }
    </style>
</head>
<body>

<nav>
    <div id="logo">HospiHub</div>
</nav>

<div id="contenedor">
    <h1>Tus Citas</h1>

    <?php
    session_start();

    
    // Conexión a la base de datos MySQL usando mysqli
    include('../conexion.php');
    $conexion = new mysqli($host, $usuario, $password, $base_de_datos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Llamar al procedimiento almacenado
    $query = "CALL Obtener_Citas(?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>\n";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID Cita</th>";
        echo "<th>Fecha</th>";
        echo "<th>Hora</th>";
        echo "<th>Médico</th>";
        echo "<th>Departamento</th>";
        echo "<th>Hospital</th>";
        echo "<th>Estado</th>";
        echo "<th>Acciones</th>";
        echo "</tr>";
        echo "</thead>";
        
        // Iterar sobre los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Id_Cita']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Hora']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Medico'] . " " . $row['Apellidos_Medico']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Departamento']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Hospital']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Estado']) . "</td>";                     
            echo "</tr>";
        }
        echo "</table>\n";
    } else {
        echo "<p>No tienes citas programadas.</p>";
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
    ?>

</div>

<a href="../menu-paciente.php" id="volver">Volver al menú de paciente <span class="material-symbols-outlined">home</span></a>

</body>
</html>