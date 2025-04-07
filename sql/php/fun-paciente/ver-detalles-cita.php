<?php
session_start();
include('../conexion.php');
$conexion = conexion();

// Verificar si el paciente ha iniciado sesión
if (!isset($_SESSION['id_paciente'])) {
    header("Location: ../login/login-paciente.php");
    exit();
}

// Obtener el ID de la cita de la URL
if (!isset($_GET['id_cita'])) {
    die("Error: No se ha especificado una cita");
}
$id_cita = $_GET['id_cita'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Detalles de la Cita</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <meta name="designer" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
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
    <h1>Detalles de la Cita</h1>

    <?php
    $query_cita = "SELECT 
                    c.Fecha, 
                    DATE_FORMAT(c.Hora, '%H:%i') AS Hora,
                    m.Nombre AS Nombre_Medico, 
                    m.Apellidos AS Apellidos_Medico,
                    d.Nombre AS Departamento,
                    h.Nombre AS Hospital
                  FROM Cita c
                  JOIN Medico m ON c.Id_medico = m.Id_medico
                  JOIN Departamento d ON m.Id_departamento = d.Id_departamento
                  JOIN Hospital h ON d.Id_hospital = h.Id_hospital
                  WHERE c.Id_cita = ?";
    
    $stmt_cita = $conexion->prepare($query_cita);
    $stmt_cita->bind_param("i", $id_cita);
    $stmt_cita->execute();
    $result_cita = $stmt_cita->get_result();

    if ($row_cita = $result_cita->fetch_assoc()) {
        echo '<div class="info-cita">';
        echo '<h2>Información de la cita</h2>';
        echo '<p><strong>Fecha:</strong> ' . htmlspecialchars($row_cita['Fecha']) . '</p>';
        echo '<p><strong>Hora:</strong> ' . htmlspecialchars($row_cita['Hora']) . '</p>';
        echo '<p><strong>Médico:</strong> ' . htmlspecialchars($row_cita['Nombre_Medico']) . ' ' . htmlspecialchars($row_cita['Apellidos_Medico']) . '</p>';
        echo '<p><strong>Departamento:</strong> ' . htmlspecialchars($row_cita['Departamento']) . '</p>';
        echo '<p><strong>Hospital:</strong> ' . htmlspecialchars($row_cita['Hospital']) . '</p>';
        echo '</div>';
    }

    $stmt_diagnostico = $conexion->prepare("CALL ObtenerDiagnosticoPorCita(?)");
    $stmt_diagnostico->bind_param("i", $id_cita);
    $stmt_diagnostico->execute();
    $result_diagnostico = $stmt_diagnostico->get_result();

    if ($row_diagnostico = $result_diagnostico->fetch_assoc()) {
        echo '<div class="diagnostico-container">';
        echo '<h2>Diagnóstico</h2>';
        echo '<p><strong>Descripción:</strong><br>' . nl2br(htmlspecialchars($row_diagnostico['Descripcion'])) . '</p>';
        echo '<p><strong>Recomendaciones:</strong><br>' . nl2br(htmlspecialchars($row_diagnostico['Recomendacion'])) . '</p>';
        echo '</div>';
    } else {
        echo '<p>No se encontró diagnóstico para esta cita.</p>';
    }
    $stmt_diagnostico->close();
    $conexion->next_result(); 
    
    $stmt_medicamentos = $conexion->prepare("CALL ObtenerMedicamentosPorCita(?)");
    $stmt_medicamentos->bind_param("i", $id_cita);
    $stmt_medicamentos->execute();
    $result_medicamentos = $stmt_medicamentos->get_result();

    if ($result_medicamentos->num_rows > 0) {
        echo '<h2>Medicamentos Recetados</h2>';
        echo '<table class="medicamentos-table">';
        echo '<tr><th>Nombre</th><th>Frecuencia de uso</th></tr>';

        while ($row_med = $result_medicamentos->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row_med['Nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($row_med['Frecuencia']) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No se recetaron medicamentos para esta cita.</p>';
    }

    $stmt_medicamentos->close();
    $conexion->close();
    ?>

    <div class="botones">
        <a href="ver-citas-paciente.php" class="btn-volver">
            <span class="material-symbols-outlined">arrow_left_alt</span> Volver a las citas
        </a>
        <a href="../menu-paciente.php" class="btn-volver">
            <span class="material-symbols-outlined">home</span> Volver al menú
        </a>
    </div>
</div>

</body>
</html>
