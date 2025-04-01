<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cita_id'], $_POST['descripcion'], $_POST['recomendacion'])) {
    // Obtener los datos del formulario
    $cita_id = $_POST['cita_id'];
    $descripcion = trim($_POST['descripcion']);
    $recomendacion = trim($_POST['recomendacion']);

    // Conectar a la base de datos
    include('../conexion.php');
    $conexion = conexion();

    try {
        // Paso 1: Insertar el diagnóstico
        $sqlDiagnostico = "CALL Insertar_Diagnostico(?, ?, ?)";
        $stmtDiagnostico = $conexion->prepare($sqlDiagnostico);
        $stmtDiagnostico->bind_param("iss", $cita_id, $descripcion, $recomendacion);
        
        if (!$stmtDiagnostico->execute()) {
            throw new Exception("Error al insertar el diagnóstico");
        }

        // Liberar resultados del primer procedimiento
        $stmtDiagnostico->close();
        
        // Limpiar resultados pendientes
        while ($conexion->next_result()) { 
            if ($result = $conexion->store_result()) {
                $result->free(); 
            }
        }

        // Obtener ID del diagnóstico
        $idDiagnostico = obtenerIdDiagnostico($conexion);

        if ($idDiagnostico <= 0) {
            throw new Exception("No se pudo obtener el ID del diagnóstico");
        }

        echo "✅ El diagnóstico se ha insertado correctamente.<br>";

        // Paso 2: Procesar medicamentos
        if (!empty($_POST['nombre_medicamento']) && !empty($_POST['frecuencia'])) {
            // Preparar la consulta una sola vez
            $sqlMedicamento = "CALL Insertar_Medicamento(?, ?, ?)";
            $stmtMedicamento = $conexion->prepare($sqlMedicamento);

            if (!$stmtMedicamento) {
                throw new Exception("Error al preparar la consulta de medicamentos: " . $conexion->error);
            }

            for ($i = 0; $i < count($_POST['nombre_medicamento']); $i++) {
                $nombre = trim($_POST['nombre_medicamento'][$i]);
                $frecuencia = trim($_POST['frecuencia'][$i]);

                if (!empty($nombre) && !empty($frecuencia)) {
                    $stmtMedicamento->bind_param("iss", $idDiagnostico, $nombre, $frecuencia);
                    
                    if ($stmtMedicamento->execute()) {
                        echo "✅ Medicamento '{$nombre}' insertado correctamente.<br>";
                        
                        // Liberar resultados después de cada ejecución
                        while ($conexion->next_result()) { 
                            if ($result = $conexion->store_result()) {
                                $result->free(); 
                            }
                        }
                    } else {
                        echo "❌ Error al insertar el medicamento '{$nombre}': " . $stmtMedicamento->error . "<br>";
                    }
                }
            }
            $stmtMedicamento->close();
        } else {
            echo "ℹ️ No se recibieron datos de medicamentos.<br>";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
    } finally {
        if ($conexion) $conexion->close();
    }
} else {
    echo "❌ No se recibieron todos los datos necesarios.<br>";
}

function obtenerIdDiagnostico($conexion) {
    // Liberar resultados previos
    while ($conexion->next_result()) { 
        if ($result = $conexion->store_result()) {
            $result->free(); 
        }
    }
    
    $sql = "SELECT Obtener_Max_Id_Diagnostico() AS max_id";
    if ($result = $conexion->query($sql)) {
        $row = $result->fetch_assoc();
        $result->free();
        return (int)$row['max_id'];
    }
    return -1;
}
?>