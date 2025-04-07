<?php
// Iniciar la sesión para acceder al id_paciente
session_start();

// Verificar si el paciente está logueado
if (!isset($_SESSION['id_paciente'])) {
    header("Location: ../login/login-paciente.php");
    exit();
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['hospital']) || !isset($_POST['departamento']) || !isset($_POST['fecha'])) {
    header("Location: elegir-citas.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Citas Disponibles</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/citas.css">

</head>
<body>

    <nav>
        <div id="logo">HospiHub</div>
    </nav>

    <div id="contenedor">
        <h1>Citas Disponibles</h1>

        <?php
        // Conectar a la base de datos MySQL
        include('../conexion.php');
        $conexion = conexion();

        // Obtener datos del formulario
        $hospital = $_POST['hospital'];
        $departamento = $_POST['departamento'];
        $fecha = $_POST['fecha'];
        $id_paciente = $_SESSION['id_paciente'];

        // Mostrar información de búsqueda
        echo "<div class='info-busqueda'>";
        echo "<h2>Hospital: " . htmlspecialchars($hospital) . "</h2>";
        echo "<h2>Departamento: " . htmlspecialchars($departamento) . "</h2>";
        echo "<h2>Fecha: " . htmlspecialchars($fecha) . "</h2>";
        echo "</div>";

        // Llamar al procedimiento almacenado para obtener citas disponibles
        $sql = "CALL Obtener_Citas_Pendientes_Cursor(?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $hospital, $departamento, $fecha);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                // Mostrar los resultados en una tabla
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Fecha</th>";
                echo "<th>Hora</th>";
                echo "<th>Médico</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Hora_Cita']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nombre_Medico']) . "</td>";
                    echo "<td>";
                    echo "<form action='actualizar-seleccion.php' method='post'>";
                    echo "<input type='hidden' name='cita_id' value='" . $row['Id_Cita'] . "'>";
                    echo "<input type='hidden' name='id_paciente' value='" . $id_paciente . "'>";
                    echo "<button type='submit' class='btn-seleccionar'>Seleccionar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='no-resultados'>No hay citas disponibles para los criterios seleccionados.</p>";
            }

            // Liberar resultado
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
        } else {
            echo "<p class='error'>Error al preparar la consulta: " . htmlspecialchars(mysqli_error($conexion)) . "</p>";
        }

        // Cerrar conexión
        mysqli_close($conexion);
        ?>

    </div>

    <br><br><br><br>
    <a href="../menu-paciente.php?id_paciente=<?php echo $id_paciente; ?>">
        Regresar al menú del paciente 
        <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>

</body>
</html>