<!DOCTYPE html>
<html lang="es">
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>HospiHub - Tus Citas</title>
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <meta name="designer" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
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
    <h1>Tus Citas</h1>

    <?php

    // Conexión a la base de datos MySQL usando mysqli
    include('../conexion.php');
    $conexion = new mysqli($host, $usuario, $password, $base_de_datos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Realizar la consulta para obtener las citas
    $query = "SELECT 
                c.Id_Cita, 
                c.Fecha, 
                DATE_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita, 
                c.Id_Medico, 
                c.Id_Paciente, 
                c.Estado
              FROM 
                Tabla_Cita c";

    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>\n";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Id de la cita</th>";
        echo "<th>Fecha de la cita</th>";
        echo "<th>Hora de la cita</th>";
        echo "<th>Id del Médico</th>";
        echo "<th>Id del Paciente</th>";
        echo "<th>Estado de la Cita</th>";
        echo "</tr>";
        echo "</thead>";
        // Iterar sobre los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
            echo "<tr>\n";
            foreach ($row as $item) {
                echo "    <td>" . htmlspecialchars($item, ENT_QUOTES) . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    } else {
        echo "<p>No se han encontrado citas.</p>";
    }

    // Cerrar la conexión
    $conexion->close();
    ?>

</div>

<a href="../menu-admin.php" id="volver">Volver al menú del admin <span class="material-symbols-outlined">home</span></a>

</body>
</html>
