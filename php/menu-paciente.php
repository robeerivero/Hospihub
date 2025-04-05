<?php
session_start();
if (!isset($_SESSION['id_paciente'])) {
    header("Location: ../login/login-paciente.php");
    exit();
}
$id_paciente = $_SESSION['id_paciente'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Gestión de Citas</title>
    <meta name="author" content="Tu nombre">
    <meta name="description" content="Descripción de la página">

    <!-- Google Fonts y estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="css/menu-principal.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <h2>Menú de Paciente <span class="material-symbols-outlined">personal_injury</span></h2>

    <div class="opcion">
        <a href="fun-paciente/elegir-citas.php">
            Solicitar una cita <span class="material-symbols-outlined">event_note</span>
        </a>
        <a href="fun-paciente/ver-citas-paciente.php">
            Ver citas <span class="material-symbols-outlined">event_note</span>
        </a>
        <a href="index.html">
            Volver al menú principal <span class="material-symbols-outlined">home</span>
        </a>
    </div>
</body>
</html>
