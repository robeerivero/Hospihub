<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cita_id']) && isset($_POST['descripcion']) && isset($_POST['recomendacion'])) {
    // Obtener los datos del formulario
    $cita_id = $_POST['cita_id'];
    $descripcion = $_POST['descripcion'];
    $recomendacion = $_POST['recomendacion'];

    // Conectar a la base de datos
    include('../conexion.php');
    $conexion = new mysqli($host, $usuario, $password, $base_de_datos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Preparar la consulta para insertar el diagnóstico
    $sqlDiagnostico = "INSERT INTO Diagnostico (cita_id, descripcion, recomendacion) VALUES (?, ?, ?)";
    $stmtDiagnostico = $conexion->prepare($sqlDiagnostico);

    // Bind de los parámetros
    $stmtDiagnostico->bind_param("iss", $cita_id, $descripcion, $recomendacion);

    // Ejecutar la consulta para insertar el diagnóstico
    $resultadoDiagnostico = $stmtDiagnostico->execute();

    // Verificar si la inserción del diagnóstico fue exitosa
    if ($resultadoDiagnostico) {
        echo "El diagnóstico se ha insertado correctamente.<br>";

        // Obtener el ID del diagnóstico insertado
        $idDiagnostico = $conexion->insert_id;

        // Verificar si se recibieron los datos de los medicamentos
        if (isset($_POST['nombre_medicamento']) && isset($_POST['frecuencia'])) {
            // Obtener los datos de los medicamentos
            $nombresMedicamentos = $_POST['nombre_medicamento'];
            $frecuencias = $_POST['frecuencia'];

            // Preparar la consulta para insertar los medicamentos asociados al diagnóstico
            $sqlMedicamento = "INSERT INTO Medicamento (id_diagnostico, nombre_medicamento, frecuencia) VALUES (?, ?, ?)";
            $stmtMedicamento = $conexion->prepare($sqlMedicamento);

            // Iterar sobre los datos de los medicamentos y ejecutar la consulta para cada uno
            for ($i = 0; $i < count($nombresMedicamentos); $i++) {
                // Obtener los datos del medicamento actual
                $nombreMedicamento = $nombresMedicamentos[$i];
                $frecuencia = $frecuencias[$i];

                // Bind de los parámetros
                $stmtMedicamento->bind_param("iss", $idDiagnostico, $nombreMedicamento, $frecuencia);

                // Ejecutar la consulta para insertar el medicamento
                $resultadoMedicamento = $stmtMedicamento->execute();

                // Verificar si la inserción del medicamento fue exitosa
                if ($resultadoMedicamento) {
                    echo "El medicamento '$nombreMedicamento' se ha asociado al diagnóstico correctamente.<br>";
                } else {
                    echo "Error al insertar el medicamento '$nombreMedicamento'.<br>";
                }
            }
        } else {
            echo "No se recibieron datos de medicamentos.<br>";
        }
    } else {
        echo "Error al insertar el diagnóstico.<br>";
    }

    // Cerrar las conexiones y liberar los recursos
    $stmtDiagnostico->close();
    $stmtMedicamento->close();
    $conexion->close();
} else {
    echo "No se recibieron todos los datos necesarios.<br>";
}
?>
