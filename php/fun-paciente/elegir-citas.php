<?php
// Iniciar la sesión para acceder al id_paciente
session_start();
$id_paciente = $_GET['id_paciente']; // Obtener el ID del paciente de la URL
echo "ID del paciente: $id_paciente";
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Elegir Citas</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, david Conde Salado">
    <meta name="designer" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/elegir-citas.css" type="text/css">
</head>
<body>  
    <header>
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <br><br><br><br><br>

    <h1>Lista de departamentos</h1>
    <?php
        // Conectar a la base de datos MySQL
        include('../conexion.php');
        $conexion = conexion(); // Llamar a la función de conexión de conexion.php

        // Consulta SQL en MySQLi
        $sql = "SELECT 
                    d.Nombre AS Nombre_departamento,
                    d.Ubicacion AS Ubicacion_departamento,
                    h.Nombre AS Nombre_hospital,
                    h.Ciudad AS Ciudad_hospital,
                    h.Calle AS Calle_hospital
                FROM 
                    Tabla_Departamento d
                JOIN Tabla_Hospital h ON d.Id_hospital = h.Id_hospital
                ORDER BY d.Nombre ASC";

        $stmt = mysqli_prepare($conexion, $sql); // Preparar la consulta
        mysqli_stmt_execute($stmt); // Ejecutar la consulta
        $result = mysqli_stmt_get_result($stmt); // Obtener el resultado

        // Crear la tabla con los resultados
        echo "<table class='table table-striped'>\n";
        echo "<thead>";
        echo "<th>Nombre Departamento</th>";
        echo "<th>Ubicación Departamento</th>";
        echo "<th>Nombre Hospital</th>";
        echo "<th>Ciudad Hospital</th>";
        echo "<th>Calle Hospital</th>";
        echo "</thead>";

        while ($row = mysqli_fetch_assoc($result)) { // Obtener los datos
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

    <br>
    <div id="contenedor">
        <h1>Buscar Citas Disponibles</h1>
        <form action="procesar-citas.php" method="post" id="formulario">
            <label for="hospital">Nombre del Hospital:</label><br>
            <input type="text" id="hospital" name="hospital" required><br><br>

            <label for="departamento">Departamento:</label><br>
            <input type="text" id="departamento" name="departamento" required><br><br>

            <label for="fecha">Fecha:</label><br>
            <input type="date" id="fecha" name="fecha" required><br><br>

            <button type="submit">Buscar Cita</button>
        </form>
    </div>
    
    <br><br><br><br>
    <a href="../menu-paciente.php">Regresar al menú del paciente 
        <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>
</body>
</html>
