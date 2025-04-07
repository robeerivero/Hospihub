<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Resultado Diagnóstico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/procesar.css"> 
</head>
<body>

<header>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<main>
    <section class="resultado-contenedor">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cita_id'], $_POST['descripcion'], $_POST['recomendacion'])) {
            include('../conexion.php');
            $conexion = conexion();
            $cita_id = $_POST['cita_id'];
            $descripcion = trim($_POST['descripcion']);
            $recomendacion = trim($_POST['recomendacion']);

            try {
                $conexion->begin_transaction();

                $sqlDiagnostico = "CALL Insertar_Diagnostico(?, ?, ?)";
                $stmtDiagnostico = $conexion->prepare($sqlDiagnostico);

                if (!$stmtDiagnostico) {
                    throw new Exception("Error al preparar la consulta: " . $conexion->error);
                }

                $stmtDiagnostico->bind_param("iss", $cita_id, $descripcion, $recomendacion);
                if (!$stmtDiagnostico->execute()) {
                    throw new Exception("Error al insertar el diagnóstico: " . $stmtDiagnostico->error);
                }

                $stmtDiagnostico->close();
                while ($conexion->next_result()) { $conexion->store_result(); }

                $sqlId = "SELECT LAST_INSERT_ID() AS id_diagnostico";
                $result = $conexion->query($sqlId);
                if (!$result) throw new Exception("Error al obtener ID del diagnóstico.");

                $row = $result->fetch_assoc();
                $idDiagnostico = $row['id_diagnostico'];
                if ($idDiagnostico <= 0) throw new Exception("ID de diagnóstico no válido");

                if (!empty($_POST['nombre_medicamento']) && !empty($_POST['frecuencia'])) {
                    $sqlMedicamento = "INSERT INTO Medicamento (Id_diagnostico, Nombre, Frecuencia) VALUES (?, ?, ?)";
                    $stmtMedicamento = $conexion->prepare($sqlMedicamento);
                    if (!$stmtMedicamento) throw new Exception("Error en consulta de medicamentos.");

                    echo "<ul class='mensaje-lista'>";
                    for ($i = 0; $i < count($_POST['nombre_medicamento']); $i++) {
                        $nombre = trim($_POST['nombre_medicamento'][$i]);
                        $frecuencia = trim($_POST['frecuencia'][$i]);

                        if (!empty($nombre) && !empty($frecuencia)) {
                            $stmtMedicamento->bind_param("iss", $idDiagnostico, $nombre, $frecuencia);
                            if (!$stmtMedicamento->execute()) {
                                throw new Exception("Error al insertar medicamento: " . $stmtMedicamento->error);
                            }
                            echo "<li>✅ Medicamento <strong>" . htmlspecialchars($nombre) . "</strong> insertado correctamente.</li>";
                        }
                    }
                    echo "</ul>";
                    $stmtMedicamento->close();
                } else {
                    echo "<p class='mensaje-info'>ℹ️ No se recibieron datos de medicamentos.</p>";
                }

                $conexion->commit();
                echo "<p class='mensaje-exito'>✅ Diagnóstico y medicamentos insertados correctamente.</p>";
            } catch (Exception $e) {
                $conexion->rollback();
                echo "<p class='mensaje-error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            } finally {
                if ($conexion) $conexion->close();
            }
        } else {
            echo "<p class='mensaje-error'>❌ No se recibieron todos los datos necesarios.</p>";
        }
        ?>
    </section>

    <div class="action-buttons">
        <button onclick="history.back()">← Volver atrás</button>
        <a href="../menu-medico.php" class="btn-return">🏠 Menú del Médico</a>
    </div>
</main>

</body>
</html>
