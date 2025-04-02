<!DOCTYPE html>
<html>
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <title>HospiHub - Login de paciente</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <meta name="designer" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>

<?php
    // Incluir el archivo de conexión a la base de datos MySQL
    include('../conexion.php');
    $conexion = conexion(); // Llamamos a la función que crea la conexión
    session_start();

    // Comprobar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar datos del formulario
        $email = $_POST["email"];
        $password = $_POST["password"];  // Cambié 'pin' a 'password', para usar una contraseña segura

        // Preparar la consulta para verificar credenciales
        $sql = "SELECT id_paciente, password FROM Paciente WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            // Verificar si se encontró el paciente con ese email
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $paciente_id, $storedPassword);
                mysqli_stmt_fetch($stmt);

                // Verificar si la contraseña ingresada coincide con el hash almacenado
                if (password_verify($password, $storedPassword)) {
                    // Iniciar sesión y redirigir al paciente
                    $_SESSION['id_paciente'] = $paciente_id;
                    header("Location: ../menu-paciente.php?id_paciente=" . $paciente_id);
                    exit();
                } else {
                    echo "<br><br><br><br><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>
                          <p style='color:red; text-align:center; font-size: 1.5em;'>Las credenciales de inicio de sesión son incorrectas. Por favor, inténtalo de nuevo.</p>
                          <hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>";
                }
            } else {
                echo "<br><br><br><br><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>
                      <p style='color:red; text-align:center; font-size: 1.5em;'>El correo electrónico no está registrado. Por favor, inténtalo de nuevo.</p>
                      <hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>";
            }

            // Cerrar la consulta
            mysqli_stmt_close($stmt);
        }

        // Cerrar conexión a la base de datos
        mysqli_close($conexion);
    }
?>

<header>   
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Iniciar sesión como paciente<span class="material-symbols-outlined">personal_injury</span></h1>

    <form action="#" method="post" id="formulario">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required>
        <br><br>

        <label for="password">Contraseña</label><br>  <!-- Cambié 'pin' a 'password' -->
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Entrar</button>
    </form>
    <br><br>
</div>

<a href=".." id="volver">Volver al inicio <span class="material-symbols-outlined">home</span></a>

</body>
</html>
