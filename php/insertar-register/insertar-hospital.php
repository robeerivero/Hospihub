<?php
    // Conexión a la base de datos MySQL
    include('../conexion.php');
    $conexion = conexion();

    // Comprobar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar datos del formulario
        $nombre = $_POST["nombre"];
        $ciudad = $_POST["ciudad"];
        $calle = $_POST["calle"];

        // Preparar la llamada al procedimiento almacenado
        $sql = "CALL Insertar_Hospital(?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            // Vincular los parámetros
            mysqli_stmt_bind_param($stmt, "sss", $nombre, $ciudad, $calle);

            // Ejecutar la sentencia
            if (mysqli_stmt_execute($stmt)) {
                echo "<p style='color: green;'>Hospital insertado correctamente.</p>";
            } else {
                echo "<p style='color: red;'>Error al insertar el hospital: " . mysqli_error($conexion) . "</p>";
            }

            // Cerrar la sentencia
            mysqli_stmt_close($stmt);
        } else {
            echo "<p style='color: red;'>Error al preparar la consulta: " . mysqli_error($conexion) . "</p>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Insertar Hospital</title>  
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <meta name="designer" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Enlaces a los archivos CSS -->
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>

<header>   
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Registrar Hospital</h1>
    
    <form action="#" method="post" id="formulario">
        <label for="nombre">Nombre del hospital</label><br>
        <input type="text" id="nombre" name="nombre" required>
    
        <br><br>
    
        <label for="ciudad">Ciudad</label><br>
        <input type="text" id="ciudad" name="ciudad" required>
            
        <br><br>
            
        <label for="calle">Calle</label><br>
        <input type="text" id="calle" name="calle" required>
            
        <br><br>

        <button type="submit">Registrar</button>
    </form>
    <br>
    <br>
</div>

<a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">
            arrow_left_alt
            </span></a> <br>

</body>
</html>