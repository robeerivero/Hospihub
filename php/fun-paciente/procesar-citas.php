<?php
// Iniciar la sesión para acceder al id_paciente
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Citas Disponibles</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <meta name="designer" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/procesar-citas.css">
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

        $hospital = $_POST['hospital'];
        $departamento = $_POST['departamento'];
        $fecha_formulario = $_POST['fecha'];

        // Convertir la fecha al formato adecuado para MySQL (YYYY-MM-DD)
        $fecha = date('Y-m-d', strtotime($fecha_formulario));

        echo "<h2>Hospital: " . htmlentities($hospital, ENT_QUOTES) . "</h2>";
        echo "<h2>Departamento: " . htmlentities($departamento, ENT_QUOTES) . "</h2>";
        echo "<h2>Fecha: " . htmlentities($fecha, ENT_QUOTES) . "</h2>";

        // Consulta SQL para obtener citas disponibles
        $sql = "SELECT 
                    c.Id_Cita, 
                    c.Fecha, 
                    TIME_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita, 
                    c.Id_Medico, 
                    CONCAT(m.Nombre, ' ', m.Apellido) AS Medico_Cita
                FROM 
                    Tabla_Cita c
                JOIN Tabla_Medico m ON c.Id_medico = m.Id_medico
                JOIN Tabla_Departamento d ON m.Id_departamento = d.Id_departamento
                JOIN Tabla_Hospital h ON d.Id_hospital = h.Id_hospital
                WHERE 
                    h.Nombre = ? 
                    AND d.Nombre = ? 
                    AND c.Fecha = ? 
                    AND c.Estado = 'Pendiente'";

        // Preparar la consulta
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $hospital, $departamento, $fecha); // Enlazar parámetros
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // Obtener resultados

        // Mostrar los resultados en una tabla
        echo "<table class='table table-striped'>\n";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Id de la cita</th>";
        echo "<th>Fecha de la cita</th>";
        echo "<th>Hora de la cita</th>";
        echo "<th>Id del Médico</th>";
        echo "<th>Médico de la Cita</th>";
        echo "<th>Seleccionar</th>";
        echo "</tr>";
        echo "</thead>";

        // Recorrer resultados
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>\n";
            foreach ($row as $item) {
                echo "<td>" . htmlentities($item, ENT_QUOTES) . "</td>\n";
            }
            // Agregar el formulario y el botón "Seleccionar" en cada fila
            echo "<td>";
            echo "<form action='actualizar-seleccion.php' method='post'>";
            echo "<input type='hidden' name='cita_id' value='" . $row['Id_Cita'] . "'>";
            echo "<button type='submit'>Seleccionar</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>\n";
        }
        echo "</table>\n";

        // Cerrar conexión
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        ?>

    </div>

    <br><br><br>
    <a href="elegir-citas.php">Volver atrás <span class="material-symbols-outlined">arrow_left_alt</span></a>

    <br>
    <a href="../menu-paciente.php">Regresar al menú del paciente <span class="material-symbols-outlined">arrow_left_alt</span></a>

</body>
</html>
