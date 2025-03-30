<?php
// Iniciar la sesión para acceder al id_paciente
session_start();

// Verificar si el paciente está logueado
if (!isset($_SESSION['id_paciente'])) {
    header("Location: ../login/login-paciente.php");
    exit();
}

$id_paciente = $_SESSION['id_paciente'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Elegir Citas</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <meta name="designer" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
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
        $conexion = conexion();

        // Usar el procedimiento almacenado para obtener departamentos y hospitales
        $sql = "CALL Obtener_Departamentos_Hospitales_Cursor()";
        
        if ($result = mysqli_query($conexion, $sql)) {
            // Crear la tabla con los resultados
            echo "<table class='table table-striped'>\n";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Nombre Departamento</th>";
            echo "<th>Ubicación</th>";
            echo "<th>Hospital</th>";
            echo "<th>Ciudad</th>";
            echo "<th>Calle</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Nombre_departamento']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Ubicacion_departamento']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Nombre_hospital']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Ciudad_hospital']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Calle_hospital']) . "</td>";
                echo "<td><a href='#formulario' onclick=\"rellenarFormulario('" . 
                     htmlspecialchars($row['Nombre_hospital'], ENT_QUOTES) . "','" . 
                     htmlspecialchars($row['Nombre_departamento'], ENT_QUOTES) . "')\">Seleccionar</a></td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
            
            // Liberar el resultado
            mysqli_free_result($result);
        } else {
            echo "<p>Error al obtener los departamentos: " . mysqli_error($conexion) . "</p>";
        }

        // Cerrar conexión
        mysqli_close($conexion);
    ?>

    <br>
    <div id="contenedor">
        <h1>Buscar Citas Disponibles</h1>
        <form action="procesar-citas.php" method="post" id="formulario">
            <input type="hidden" name="id_paciente" value="<?php echo $id_paciente; ?>">
            
            <label for="hospital">Nombre del Hospital:</label><br>
            <input type="text" id="hospital" name="hospital" required><br><br>

            <label for="departamento">Departamento:</label><br>
            <input type="text" id="departamento" name="departamento" required><br><br>

            <label for="fecha">Fecha:</label><br>
            <input type="date" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>"><br><br>

            <button type="submit">Buscar Cita</button>
        </form>
    </div>
    
    <script>
    function rellenarFormulario(hospital, departamento) {
        document.getElementById('hospital').value = hospital;
        document.getElementById('departamento').value = departamento;
        document.getElementById('fecha').focus();
    }
    </script>
    
    <br><br><br><br>
    <a href="../menu-paciente.php">Regresar al menú del paciente 
        <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>
</body>
</html>