<?php
include('../conexion.php');
$conexion = conexion();

// Inicializar mensaje vacío
$mensaje = "";

// Inicializar las variables para los valores del formulario
$nombre = $apellidos = $telefono = $fecha_nacimiento = $ciudad = $calle = $email = $pin = $departamento = $hospital = "";

// Obtener el ID del médico desde la URL
if (isset($_GET['id'])) {
    $id_medico = $_GET['id'];
    
    // Obtener los datos actuales del médico
    $sql = "CALL Obtener_Medicos_Cursor(?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_medico);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $medico = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    // Asignar los valores a las variables del formulario
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $nombre = $medico['Nombre'];
        $apellidos = $medico['Apellidos'];
        $telefono = $medico['Telefono'];
        $fecha_nacimiento = $medico['Fecha_nacimiento'];
        $ciudad = $medico['Ciudad'];
        $calle = $medico['Calle'];
        $email = $medico['Email'];
        $pin = $medico['PIN'];
        $departamento = $medico['Nombre_departamento'];
        $hospital = $medico['Nombre_hospital'];
    }
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
    $departamento = $_POST['departamento'];
    $hospital = $_POST['hospital'];

    try {
        // Realizar la conexión y la ejecución de la consulta
        $sql_update = "CALL Editar_Medico(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_update = mysqli_prepare($conexion, $sql_update);

        // Asegúrate de que todos los valores estén bien definidos
        mysqli_stmt_bind_param($stmt_update, "issssssssss", $id_medico, $nombre, $apellidos, $telefono, $fecha_nacimiento, $ciudad, $calle, $email, $pin, $departamento, $hospital);

        if (mysqli_stmt_execute($stmt_update)) {
            $mensaje = "<p style='color: green; text-align: center;'>Médico actualizado correctamente.</p>";
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

    <title>HospiHub - Editar Médico</title>  
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <div id="contenedor">
        <h1><?php echo $mensaje; ?>Editar Datos del Médico<span class="material-symbols-outlined">personal_injury</span></h1>
    
        <form action="" method="post" id="formulario">
            <label for="nombre">Nombre</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            <br><br>
            <label for="apellidos">Apellidos</label><br>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>" required>
            <br><br>
            <label for="telefono">Teléfono</label><br>
            <input type="number" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            <br><br>
            <label for="fecha">Fecha de nacimiento</label><br>
            <input type="date" id="fecha" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>" required>
            <br><br>
            <label for="ciudad">Ciudad</label><br>
            <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($ciudad); ?>" required>
            <br><br>
            <label for="calle">Calle</label><br>
            <input type="text" id="calle" name="calle" value="<?php echo htmlspecialchars($calle); ?>" required>
            <br><br>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <br><br>
            <label for="pin">Pin</label><br>
            <input type="number" id="pin" name="pin" value="<?php echo htmlspecialchars($pin); ?>" required>
            <br><br>
            <label for="departamento">Departamento</label><br>
            <input type="text" id="departamento" name="departamento" value="<?php echo htmlspecialchars($departamento); ?>" required>
            <br><br>
            <label for="hospital">Hospital</label><br>
            <input type="text" id="hospital" name="hospital" value="<?php echo htmlspecialchars($hospital); ?>" required>
            <br><br>
            <button type="submit">Guardar Cambios</button>
        </form>
        <br><br>
    </div>
    
    <a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span></a> <br>
    <br>
    <a href="../ver/ver-medicos.php" id="volver">Volver a la lista de médicos <span class="material-symbols-outlined">list</span></a>
</body>
</html>
