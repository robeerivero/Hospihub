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
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <meta name="designer" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/ver.css">
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
    $conexion = conexion(); // Llamar a la función de conexión de conexion.php

    // Consulta SQL en MySQLi
    $sql = "SELECT 
                c.Id_Cita, 
                c.Fecha, 
                TIME_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita, 
                c.Id_Medico, 
                c.Estado
            FROM 
                Tabla_Cita c
            JOIN Tabla_Paciente p ON c.Id_paciente = p.Id_paciente
            JOIN Tabla_Medico m ON c.Id_medico = m.Id_medico
            WHERE
                c.Id_Paciente = ?";

    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $paciente_id); // Enlazar parámetros
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // Obtener resultados

    // Crear tabla para mostrar citas
    echo "<table class='table table-striped'>\n";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID de la Cita</th>";
    echo "<th>Fecha de la Cita</th>";
    echo "<th>Hora de la Cita</th>";
    echo "<th>ID del Médico</th>";
    echo "<th>Estado de la Cita</th>";
    echo "<th>Acciones</th>"; // Columna para botones de acciones
    echo "</tr>";
    echo "</thead>";

    // Recorrer resultados
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>\n";
        foreach ($row as $item) {
            echo "<td>" . htmlentities($item, ENT_QUOTES) . "</td>\n";
        }

        // Agregar botones de acciones según el estado de la cita
        if ($row['Estado'] === 'Diagnostico Completo') {
            echo "<td><a href='ver-detalles-cita.php?id_cita=" . $row['Id_Cita'] . "'>Ver detalles</a></td>";
        } elseif ($row['Estado'] === 'Paciente Asignado') {
            echo "<td><a href='cancelar-cita.php?id_cita=" . $row['Id_Cita'] . "' style='background-color: red;'>Cancelar Cita</a></td>";
        } else {
            echo "<td></td>";
        }
        echo "</tr>\n";
    }
    echo "</table>\n";

    // Cerrar conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    ?>

</div>

<a href="../menu-paciente.php" id="volver">Volver al menú de paciente 
    <span class="material-symbols-outlined">home</span>
</a>

</body>
</html>
