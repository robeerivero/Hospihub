<?php
// Iniciar la sesión para obtener el ID del paciente
session_start();

// Verificar si la sesión contiene el ID del paciente
if (!isset($_SESSION['id_paciente'])) {
    echo "Error: No se ha iniciado sesión.";
    exit;
}

$paciente_id = $_SESSION['id_paciente'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Tus Citas</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <meta name="designer" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/ver-detalles-cita.css">
</head>
<body>

<nav>
    <div id="logo">HospiHub</div>
</nav>

<div id="contenedor">
    <h1 style="color: black;">Tus Citas</h1>

    <?php
    // Conectar a la base de datos MySQL
    include('../conexion.php');
    $conexion = conexion();

    // Llamar al procedimiento almacenado para obtener citas del paciente
    $sql = "CALL Obtener_Citas_Paciente(?)";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $paciente_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Crear tabla para mostrar citas
        echo "<table class='table table-striped'>\n";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Fecha</th>";
        echo "<th>Hora</th>";
        echo "<th>Médico</th>";
        echo "<th>Departamento</th>";
        echo "<th>Hospital</th>";
        echo "<th>Estado</th>";
        echo "<th>Acciones</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Recorrer resultados
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Hora']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Medico'] . " " . $row['Apellidos_Medico']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Departamento']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Hospital']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Estado']) . "</td>";
            
            // Acciones según el estado
            echo "<td>";
            if ($row['Estado'] === 'Diagnostico Completo') {
                echo "<a href='ver-detalles-cita.php?id_cita=" . $row['Id_Cita'] . "' class='btn-ver'>Ver diagnóstico</a>";
            } elseif ($row['Estado'] === 'Paciente Asignado') {
                echo "<a href='cancelar-cita.php?id_cita=" . $row['Id_Cita'] . "' class='btn-cancelar'>Cancelar</a>";
            }
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No tienes citas programadas.</p>";
    }

    // Cerrar la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    ?>

</div>

<a href="../menu-paciente.php" id="volver">Volver al menú de paciente 
    <span class="material-symbols-outlined">home</span>
</a>

</body>
</html>