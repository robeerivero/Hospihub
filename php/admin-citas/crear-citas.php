<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>HospiHub - Crear todas las citas</title>
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
    <h1>Cancelar todas las citas</h1>
    <?php
    // Establecer la conexión a la base de datos con MySQLi
    include('../conexion.php');
    $conexion = new mysqli($host, $usuario, $password, $base_de_datos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Ejecutar la consulta para crear citas
    $query = "CALL Crear_Citas()";  // Suponiendo que Crear_Citas es un procedimiento almacenado
    if ($conexion->query($query) === TRUE) {
        echo "<br><br><hr style='border-top: 3px solid orange; border-bottom: 3px solid orange;'>
              <p style='color:orange; text-align:center; font-size: 1.5em;'>Se han creado citas para todos los médicos.</p>
              <hr style='border-top: 3px solid orange; border-bottom: 3px solid orange;'>";
    } else {
        echo "Error al crear las citas: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
    ?>
</div>

<a href="../menu-admin.php" id="volver">Volver al menú del admin <span class="material-symbols-outlined">home</span></a>

</body>
</html>
