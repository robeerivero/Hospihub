<?php
include('../conexion.php');
$conexion = conexion();
session_start();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pin = $_POST["pin"];

    $sql = "SELECT id_paciente, pin FROM Paciente WHERE email = ? AND Nombre = 'admin'";

    if ($stmt = mysqli_prepare($conexion, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $admin_id, $hashed_pin);

        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($pin, $hashed_pin)) {
                $_SESSION['id_paciente'] = $admin_id;
                header("Location: ../menu-admin.php?id_paciente=" . $admin_id);
                exit();
            } else {
                $mensaje = "<p style='color: red; text-align: center;'>PIN incorrecto</p>";
            }
        } else {
            $mensaje = "<p style='color: red; text-align: center;'>Credenciales inválidas</p>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Login de admin</title>
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
    <h1>Iniciar sesión como admin <span class="material-symbols-outlined">admin_panel_settings</span></h1>
    <?php echo $mensaje; ?>

    <form action="" method="post" id="formulario">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required>

        <br><br>

        <label for="pin">Pin</label><br>
        <input type="password" id="pin" name="pin" required>
        
        <br><br>
        
        <button type="submit">Entrar</button>
    </form>
    <br><br>
</div>

<a href=".." id="volver">Volver al inicio <span class="material-symbols-outlined">home</span></a>

</body>
</html>
