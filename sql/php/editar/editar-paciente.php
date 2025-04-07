<?php
include('../conexion.php');
$conexion = conexion();

// Inicializar mensaje vacío
$mensaje = "";

// Obtener el ID del paciente desde la URL
if (isset($_GET['id'])) {
    $id_paciente = $_GET['id'];
    
    // Obtener los datos actuales del paciente
    $sql = "CALL Obtener_Pacientes_Cursor($id_paciente)";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $paciente = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Actualizar los datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ciudad = $_POST['ciudad'];
    $calle = $_POST['calle'];
    $email = $_POST['email'];
    $pin = $_POST['pin'];

    $sql_update = "CALL Editar_Paciente(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "issssssss", $id_paciente, $nombre, $apellidos, $telefono, $fecha_nacimiento, $ciudad, $calle, $email, $pin);

    if (mysqli_stmt_execute($stmt_update)) {
        $mensaje = "<p style='color: green; text-align: center;'>Paciente actualizado correctamente.</p>";
    } else {
        $mensaje = "<p style='color: red; text-align: center;'>Error al actualizar: " . mysqli_error($conexion) . "</p>";
    }

    mysqli_stmt_close($stmt_update);
}


mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <title>HospiHub - Editar Paciente</title>  
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;900&display=swap" rel="stylesheet">
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
        <h1><?php echo $mensaje; ?>Editar Datos del Paciente<span class="material-symbols-outlined">personal_injury</span></h1>
    
        <form action="" method="post" id="formulario">
            <label for="nombre">Nombre</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($paciente['Nombre']); ?>" required>
            <br><br>
            <label for="apellidos">Apellidos</label><br>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($paciente['Apellidos']); ?>" required>
            <br><br>
            <label for="telefono">Teléfono</label><br>
            <input type="number" id="telefono" name="telefono" value="<?php echo htmlspecialchars($paciente['Telefono']); ?>" required>
            <br><br>
            <label for="fecha">Fecha de nacimiento</label><br>
            <input type="date" id="fecha" name="fecha_nacimiento" value="<?php echo htmlspecialchars($paciente['Fecha_nacimiento']); ?>" required>
            <br><br>
            <label for="ciudad">Ciudad</label><br>
            <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($paciente['Ciudad']); ?>" required>
            <br><br>
            <label for="calle">Calle</label><br>
            <input type="text" id="calle" name="calle" value="<?php echo htmlspecialchars($paciente['Calle']); ?>" required>
            <br><br>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($paciente['Email']); ?>" required>
            <br><br>
            <label for="pin">Pin</label><br>
            <input type="number" id="pin" name="pin" value="<?php echo htmlspecialchars($paciente['PIN']); ?>" required>
            <br><br>
            <button type="submit">Guardar Cambios</button>
        </form>
        <br><br>
    </div>
    
    <a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span></a> <br>
    <br>
    <a href="../ver/ver-pacientes.php" id="volver">Volver a la lista de pacientes <span class="material-symbols-outlined">list</span></a>
</body>
</html>
