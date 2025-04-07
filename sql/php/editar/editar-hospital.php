<?php
include('../conexion.php');
$conexion = conexion();

// Inicializar mensaje vacío
$mensaje = "";

// Obtener el ID del hospital desde la URL
if (isset($_GET['id'])) {
    $id_hospital = $_GET['id'];
    
    // Obtener los datos actuales del paciente
    $sql = "CALL Obtener_Hospitales_Cursor($id_hospital)";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $hospital = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Asignar los valores a las variables del formulario
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $nombre = $hospital['Nombre_hospital'];
        $ciudad = $hospital['Ciudad_hospital'];
        $calle = $hospital['Calle_hospital'];
    }
}

// Actualizar los datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $calle = $_POST['calle'];

    $sql_update = "CALL Editar_Hospital(?, ?, ?, ?)";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "isss", $id_hospital, $nombre, $ciudad, $calle);

    if (mysqli_stmt_execute($stmt_update)) {
        $mensaje = "<p style='color: green; text-align: center;'>Hospital actualizado correctamente.</p>";
    } else {
        $mensaje = "<p style='color: red; text-align: center;'>Error al actualizar: " . mysqli_error($conexion) . "</p>";
    }

    mysqli_stmt_close($stmt_update);
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <title>HospiHub - Editar Hospital</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <header>
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <div id="contenedor">
        <h1><?php echo $mensaje; ?>Editar Datos del Hospital</h1>
    
        <form action="" method="post" id="formulario">
            <label for="nombre">Nombre del Hospital</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($hospital['Nombre_hospital']); ?>" required>
            <br><br>
            <label for="ciudad">Ciudad</label><br>
            <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($hospital['Ciudad_hospital']); ?>" required>
            <br><br>
            <label for="calle">Calle</label><br>
            <input type="text" id="calle" name="calle" value="<?php echo htmlspecialchars($hospital['Calle_hospital']); ?>" required>
            <br><br>
            <button type="submit">Guardar Cambios</button>
        </form>
        <br><br>
    </div>
    
    <a href="../menu-admin.php">Regresar al menú del administrador</a> <br>
    <br>
    <a href="../ver/ver-hospitales.php" id="volver">Volver a la lista de hospitales</a>
</body>
</html>
