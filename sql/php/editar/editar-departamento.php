<?php
include('../conexion.php');
$conexion = conexion();

// Inicializar mensaje vacío
$mensaje = "";

// Obtener el ID del departamento desde la URL
if (isset($_GET['id'])) {
    $id_departamento = $_GET['id'];

    // Obtener los datos actuales del departamento
    $sql = "CALL Obtener_Departamentos_Hospitales_Cursor(?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_departamento);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $departamento = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Procesar la actualización si el formulario se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_hospital = $_POST['nombre_hospital'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];

    try {
        // Llamar al procedimiento almacenado que actualizará el departamento tomando el ID del hospital a partir del nombre
        $sql_update = "CALL Editar_Departamento(?, ?, ?, ?)";
        $stmt_update = mysqli_prepare($conexion, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "isss", $id_departamento, $nombre_hospital, $nombre, $ubicacion);

        if (mysqli_stmt_execute($stmt_update)) {
            $mensaje = "<p style='color: green; text-align: center;'>Departamento actualizado correctamente.</p>";
        } else {
            throw new Exception("Error al ejecutar la consulta: " . mysqli_error($conexion));
        }

        mysqli_stmt_close($stmt_update);
    } catch (Exception $e) {
        // Captura la excepción y muestra el mensaje de error
        $mensaje = "<p style='color: red; text-align: center;'>Error al editar: " . $e->getMessage() . "</p>";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
<head>

    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <title>HospiHub - Editar Departamento</title>  
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <div id="contenedor">
        <h1><?php echo $mensaje; ?>Editar Datos del Departamento<span class="material-symbols-outlined">business</span></h1>
    
        <form action="" method="post" id="formulario">
            <label for="nombre_hospital">Nombre del hospital</label><br>
            <input type="text" id="nombre_hospital" name="nombre_hospital" value="<?php echo htmlspecialchars($departamento['Nombre_hospital']); ?>" required>
            <br><br>

            <label for="nombre">Nombre del Departamento</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($departamento['Nombre_departamento']); ?>" required>
            <br><br>

            <label for="ubicacion">Ubicación</label><br>
            <input type="text" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($departamento['Ubicacion_departamento']); ?>" required>
            <br><br>

            <button type="submit">Guardar Cambios</button>
        </form>
        <br><br>
    </div>
    
    <a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span></a> <br>
    <br>
    <a href="../ver/ver-departamentos.php" id="volver">Volver a la lista de departamentos <span class="material-symbols-outlined">list</span></a>
</body>
</html>
