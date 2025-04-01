<?php
// Incluir el archivo de conexión a la base de datos MySQL
include('../conexion.php');
$conexion = conexion();  // Llamada a la función de conexión a la base de datos
session_start();

// Inicializar mensaje de error
$mensaje = "";

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $email = $_POST["email"];
    $pin = $_POST["pin"];
    
    // Preparar la consulta SQL para verificar las credenciales y que sea el admin
    $sql = "SELECT id_paciente FROM Paciente WHERE email = ? AND pin = ? AND Nombre = 'admin'";

    // Preparar la sentencia
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "si", $email, $pin);  // "si" significa que email es string y pin es integer

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Vincular el resultado
        mysqli_stmt_bind_result($stmt, $paciente_id);

        // Verificar si se obtuvo un resultado y que el PIN sea 123
        if (mysqli_stmt_fetch($stmt) && $pin == 123) {
            // Si es el usuario correcto, iniciar sesión
            $_SESSION['id_paciente'] = $paciente_id;

            // Redirigir al admin al menú de administrador
            header("Location: ../menu-admin.php?id_paciente=" . $paciente_id);
            exit();
        } else {
            // Si no se encuentran las credenciales, mostrar mensaje de error
            $mensaje = "<p style='color: red; text-align: center;'>Acceso denegado</p>";
        }

        // Cerrar la sentencia
        mysqli_stmt_close($stmt);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Login de paciente</title>
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
    <h1><?php echo $mensaje; ?>Iniciar sesión como admin<span class="material-symbols-outlined">personal_injury</span></h1>

    <form action="" method="post" id="formulario">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required>

        <br><br>

        <label for="pin">Pin</label><br>
        <input type="number" id="pin" name="pin" required>
        
        <br><br>
        
        <button type="submit">Entrar</button>
    </form>
    <br><br>
</div>

<a href=".." id="volver">Volver al inicio <span class="material-symbols-outlined">home</span></a>

</body>
</html>
