<?php
// Iniciar la sesión para obtener el ID del médico
session_start();

// Verificar si la sesión contiene el ID del médico
if (!isset($_SESSION['medico_id'])) {
    echo "Error: No se ha iniciado sesión.";
    exit;
}

$medico_id = $_SESSION['medico_id'];
$email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Citas Disponibles</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Jesús Javier Gallgo Ibañez, Roberto Rivero Díaz, David Conde Salado">
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
        <h1>Todas sus Citas</h1>
        <h2>Médico: <?php echo htmlentities($email, ENT_QUOTES); ?></h2>

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
                JOIN Tabla_Medico m ON c.Id_medico = m.Id_medico
                JOIN Tabla_Departamento d ON m.Id_departamento = d.Id_departamento
                JOIN Tabla_Hospital h ON d.Id_hospital = h.Id_hospital
                WHERE
                    c.Id_Medico = ?";

        // Preparar la consulta
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $medico_id); // Enlazar parámetros
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
        echo "</tr>";
        echo "</thead>";

        // Recorrer resultados
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>\n";
            foreach ($row as $item) {
                echo "<td>" . htmlentities($item, ENT_QUOTES) . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";

        // Cerrar conexión
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        ?>

    </div>

    <a href="../menu-medico.php" id="volver">Volver al menú de médico 
        <span class="material-symbols-outlined">home</span>
    </a>

</body>
</html>
