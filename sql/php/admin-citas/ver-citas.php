<?php
session_start();
include('../conexion.php');
$conexion = conexion();

$query = "CALL Obtener_Citas()";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Citas - HospiHub</title>
    <link rel="stylesheet" href="../css/citas.css"> <!-- Asegúrate que esta ruta esté bien -->
</head>
<body>
    <h1>Listado de Citas</h1>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table class='table table-striped'>\n";
        echo "<thead><tr>
                <th>ID Cita</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Departamento</th>
                <th>Hospital</th>
                <th>Estado</th>
              </tr></thead>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Id_Cita']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Hora']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre_Paciente'] . " " . $row['Apellido_Paciente']) . "</td>";
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

    $conexion->close();
    ?>
</body>
</html>
