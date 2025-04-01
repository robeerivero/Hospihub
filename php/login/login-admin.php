<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Login de administrador</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <meta name="designer" content="David Conde Salado, Jesús Javier Gallego Ibañez, Roberto Rivero Díaz">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Enlaces a los archivos CSS -->
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>

<?php
// Incluir el archivo de conexión a la base de datos MySQL
include('../conexion.php');
$conexion = conexion();  // Llamada a la función de conexión a la base de datos
session_start();

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];  // Cambié 'pin' a 'password', porque es una contraseña en texto claro
    
    // Preparar la consulta SQL para verificar las credenciales
    $sql = "SELECT id_admin, password FROM Admin WHERE email = ?";

    // Preparar la sentencia
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "s", $email);  // "s" significa que email es un string

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Vincular el resultado
        mysqli_stmt_bind_result($stmt, $admin_id, $storedPassword);

        // Verificar si se obtuvo un resultado
        if (mysqli_stmt_fetch($stmt)) {
            // Verificar si la contraseña ingresada coincide con el hash almacenado
            if (password_verify($password, $storedPassword)) {
                // Si la contraseña es correcta, iniciar sesión
                $_SESSION['admin_id'] = $admin_id;

                // Redirigir al administrador a su página de menú
                header("Location: ../admin-dashboard.php");
                exit();
            } else {
                // Si la contraseña es incorrecta
                echo "<br><br><br><br><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'><p style='color:red; text-align:center; font-size: 1.5em;'>Las credenciales de inicio de sesión son incorrectas. Por favor, inténtalo de nuevo.</p><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>";
            }
        } else {
            // Si no se encuentra el administrador
            echo "<br><br><br><br><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'><p style='color:red; text-align:center; font-size: 1.5em;'>El correo electrónico no está registrado. Por favor, inténtalo de nuevo.</p><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>";
        }

        // Cerrar la sentencia
        mysqli_stmt_close($stmt);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

<header>   
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Iniciar sesión como administrador<span class="material-symbols-outlined">
        personal_injury</span>
    </h1>

    <form action="#" method="post" id="formulario">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required>

        <br><br>

        <label for="password">Contraseña</label><br>
        <input type="password" id="password" name="password" required>  <!-- Cambié "pin" a "password" -->

        <br><br>
        
        <button type="submit">Entrar</button>
    </form>
    <br><br>
</div>

<a href=".." id="volver">Volver al inicio <span class="material-symbols-outlined">
        home
    </span>
</a>

</body>
</html>
