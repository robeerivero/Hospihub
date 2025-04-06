<!DOCTYPE html>
<html>
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <title>HospiHub - Login de paciente</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado Miguel Cabral Ramírez">
    <meta name="designer" content="David Conde Salado, Jesús Javier Gallego Ibañez, Roberto Rivero Díaz Miguel Cabral Ramírez">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Enlaces a los archivos CSS -->
    <link rel="stylesheet" href="../css/registro.css">
    <!-- Enlace al archivo JavaScript -->
    
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
    $pin = $_POST["pin"];  // El PIN ingresado por el usuario

    // Preparar la consulta SQL para recuperar el hash del PIN desde la base de datos
    $sql = "SELECT id_paciente, pin FROM Paciente WHERE email = ?";

    // Preparar la sentencia
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Vincular el parámetro email
        mysqli_stmt_bind_param($stmt, "s", $email);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Vincular los resultados
        mysqli_stmt_bind_result($stmt, $paciente_id, $hashed_pin);

        // Verificar si se obtuvo un resultado
        if (mysqli_stmt_fetch($stmt)) {
            // Depuración: Ver valores
            echo "PIN ingresado: " . $pin . "<br>";
            echo "Hash en base de datos: " . $hashed_pin . "<br>";

            // Usar password_verify para comparar el PIN ingresado con el hash almacenado
            if (password_verify($pin, $hashed_pin)) {
                // Si la comparación es correcta, iniciar sesión
                echo "¡Inicio de sesión exitoso!";
                $_SESSION['id_paciente'] = $paciente_id;

                // Redirigir al paciente a su menú
                header("Location: ../menu-paciente.php?id_paciente=" . $paciente_id);
                exit();
            } else {
                // Si el PIN es incorrecto
                echo "<p style='color:red;'>El PIN es incorrecto. Por favor, inténtalo de nuevo.</p>";
            }
                // Redirigir al paciente a su menú
                header("Location: ../menu-paciente.php?id_paciente=" . $paciente_id);
                exit();
            } else {
                // Si el PIN es incorrecto
                echo "<p style='color:red;'>El PIN es incorrecto. Por favor, inténtalo de nuevo.</p>";
            }
        } else {
            // Si no se encuentra el usuario
            echo "<p style='color:red;'>No se encontró un usuario con ese email.</p>";
            // Si no se encuentra el usuario
            echo "<p style='color:red;'>No se encontró un usuario con ese email.</p>";
        }
        // Cerrar la sentencia
        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color:red;'>Error al preparar la consulta.</p>";
    } else {
        echo "<p style='color:red;'>Error al preparar la consulta.</p>";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>

<header>   
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Iniciar sesión como paciente<span class="material-symbols-outlined">
        personal_injury</span>
    </h1>

    <form action="#" method="post" id="formulario">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required>

        <br><br>

        <label for="pin">Pin</label><br>
        <input type="password" id="pin" name="pin" required>
        
        <br><br>
        
        <button type="submit">Iniciar sesión</button>

    </form>
    <br><br>
</div>

<a href=".." id="volver">Volver al inicio <span class="material-symbols-outlined">
        home
    </span>
</a>

</body>
</html>
