<!DOCTYPE html>
<html>
<head>
    <title>Detalles de la Cita</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <meta name="designer" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Enlaces a los archivos CSS -->
    <link rel="stylesheet" href="../css/ver.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<nav>
    <div id="logo">HospiHub</div>
</nav>

<div id="contenedor">
    <h1>Detalles de la Cita</h1>

    <?php
    include('../conexion.php');
    $conexion = conexion();

    // Obtener el ID de la cita de la URL
    $id_cita = $_GET['id_cita'];

    // Consulta para diagnóstico
    $query_diagnostico = "SELECT 
                            d.Descripcion AS descripcion,
                            d.Recomendacion AS recomendacion
                          FROM Tabla_Cita c
                          JOIN Tabla_Diagnostico d ON c.Id_diagnostico = d.Id_diagnostico
                          WHERE c.Id_Cita = ?";
    
    $stmt_diagnostico = mysqli_prepare($conexion, $query_diagnostico);
    mysqli_stmt_bind_param($stmt_diagnostico, "i", $id_cita);
    mysqli_stmt_execute($stmt_diagnostico);
    $result_diagnostico = mysqli_stmt_get_result($stmt_diagnostico);

    echo "<h2>Diagnóstico:</h2>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result_diagnostico)) {
        echo "<li><strong>Descripción:</strong> " . htmlspecialchars($row['descripcion']) . "</li>";
        echo "<li><strong>Recomendación:</strong> " . htmlspecialchars($row['recomendacion']) . "</li>";
    }
    echo "</ul>";

    // Consulta para medicamentos
    $query_medicamentos = "SELECT 
                             m.Nombre AS nombre,
                             m.Frecuencia AS frecuencia
                           FROM Tabla_Cita c
                           JOIN Tabla_Diagnostico d ON c.Id_diagnostico = d.Id_diagnostico
                           LEFT JOIN Tabla_Medicamento m ON d.Id_diagnostico = m.Id_diagnostico
                           WHERE c.Id_Cita = ?";
    
    $stmt_medicamentos = mysqli_prepare($conexion, $query_medicamentos);
    mysqli_stmt_bind_param($stmt_medicamentos, "i", $id_cita);
    mysqli_stmt_execute($stmt_medicamentos);
    $result_medicamentos = mysqli_stmt_get_result($stmt_medicamentos);

    echo "<h2>Medicamentos:</h2>";
    echo "<table>";
    echo "<tr><th>Nombre</th><th>Frecuencia</th></tr>";
    while ($med_row = mysqli_fetch_assoc($result_medicamentos)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($med_row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($med_row['frecuencia']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Liberar recursos
    mysqli_free_result($result_diagnostico);
    mysqli_free_result($result_medicamentos);
    mysqli_stmt_close($stmt_diagnostico);
    mysqli_stmt_close($stmt_medicamentos);
    mysqli_close($conexion);
    ?>

</div>

<a href="ver-citas-paciente.php" id="volver">Volver a las citas <span class="material-symbols-outlined">
        arrow_left_alt
    </span></a>
    <br><br>
<a href="../menu-paciente.php" id="volver">Volver al menú de paciente <span class="material-symbols-outlined">
    home
    </span>
</a>

</body>
</html>