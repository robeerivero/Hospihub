<?php
// 1. Información básica de la cita
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
$row_cita = $result_cita->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalles de Cita <?php echo $id_cita; ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #2c3e50; text-align: center; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #3498db; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">HospiHub</div>
        <h1>Detalles de la Cita #<?php echo $id_cita; ?></h1>
    </div>

    <div class="section">
        <h2>Información de la cita</h2>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($row_cita['Fecha']); ?></p>
        <p><strong>Hora:</strong> <?php echo htmlspecialchars($row_cita['Hora']); ?></p>
        <p><strong>Médico:</strong> <?php echo htmlspecialchars($row_cita['Nombre_Medico'].' '.$row_cita['Apellidos_Medico']); ?></p>
        <p><strong>Departamento:</strong> <?php echo htmlspecialchars($row_cita['Departamento']); ?></p>
        <p><strong>Hospital:</strong> <?php echo htmlspecialchars($row_cita['Hospital']); ?></p>
    </div>

    <?php
    // 2. Diagnóstico
    $query_diagnostico = "SELECT 
                            diag.Descripcion, 
                            diag.Recomendacion
                          FROM Cita c
                          JOIN Diagnostico diag ON c.Id_diagnostico = diag.Id_diagnostico
                          WHERE c.Id_cita = ?";
    
    $stmt_diagnostico = $conexion->prepare($query_diagnostico);
    $stmt_diagnostico->bind_param("i", $id_cita);
    $stmt_diagnostico->execute();
    $result_diagnostico = $stmt_diagnostico->get_result();

    if ($row_diagnostico = $result_diagnostico->fetch_assoc()): ?>
        <div class="section">
            <h2>Diagnóstico</h2>
            <p><strong>Descripción:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($row_diagnostico['Descripcion'])); ?></p>
            <p><strong>Recomendaciones:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($row_diagnostico['Recomendacion'])); ?></p>
        </div>
    <?php endif;

    // 3. Medicamentos
    $query_medicamentos = "SELECT 
                            med.Nombre, 
                            med.Frecuencia
                          FROM Cita c
                          JOIN Diagnostico diag ON c.Id_diagnostico = diag.Id_diagnostico
                          JOIN Medicamento med ON diag.Id_diagnostico = med.Id_diagnostico
                          WHERE c.Id_cita = ?";
    
    $stmt_medicamentos = $conexion->prepare($query_medicamentos);
    $stmt_medicamentos->bind_param("i", $id_cita);
    $stmt_medicamentos->execute();
    $result_medicamentos = $stmt_medicamentos->get_result();

    if ($result_medicamentos->num_rows > 0): ?>
        <div class="section">
            <h2>Medicamentos Recetados</h2>
            <table>
                <tr><th>Nombre</th><th>Frecuencia de uso</th></tr>
                <?php while ($row_med = $result_medicamentos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row_med['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row_med['Frecuencia']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="footer">
        <p>Generado el <?php echo date('d/m/Y H:i'); ?></p>
    </div>
</body>
</html>
<?php
// Cerrar conexiones
$stmt_cita->close();
$stmt_diagnostico->close();
$stmt_medicamentos->close();
?>