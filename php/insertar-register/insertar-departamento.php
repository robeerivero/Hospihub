<!--NO FUNCIONA BIEN, NO AÑADE EL ID DEL HOSPITAL NI MUESTRA MENSAJES
DE ERRORES AL REGISTRAR DEPARTAMENTO INCORRECTO -->

<?php
    // Conexión a la base de datos MySQL
    include('../conexion.php');
    $conexion = conexion();
    
    // Comprobar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar datos del formulario
        $nombre_hospital = $_POST["nombre_hospital"];
        $nombre_departamento = $_POST["nombre_departamento"];
        $ubicacion = $_POST["ubicacion"];

        // Preparar la llamada al procedimiento almacenado
        $sql = "CALL Insertar_Departamento(?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            // Vincular los parámetros
            mysqli_stmt_bind_param($stmt, "sss", $nombre_hospital, $nombre_departamento, $ubicacion);

            // Ejecutar la sentencia
            if (mysqli_stmt_execute($stmt)) {
                // Obtener el mensaje de éxito
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $mensaje);
                mysqli_stmt_fetch($stmt);
                echo "<p style='color: green;'>$mensaje</p>";
            } else {
                // Capturar el error específico del procedimiento almacenado
                $error = mysqli_error($conexion);
                if (strpos($error, "El hospital no existe") !== false) {
                    echo "<p style='color: red;'>Error: El hospital no existe.</p>";
                } else {
                    echo "<p style='color: red;'>Error al insertar el departamento: $error</p>";
                }
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
    <title>HospiHub - Insertar Departamento</title>  
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
    <h1>Registrar Departamento</h1>
    
    <form action="#" method="post" id="formulario">
        <label for="nombre_hospital">Nombre del hospital</label><br>
        <input type="text" id="nombre_hospital" name="nombre_hospital" required>
    
        <br><br>
    
        <label for="nombre_departamento">Nombre del departamento</label><br>
        <input type="text" id="nombre_departamento" name="nombre_departamento" required>
            
        <br><br>
            
        <label for="ubicacion">Ubicación</label><br>
        <input type="text" id="ubicacion" name="ubicacion" required>
            
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