<!DOCTYPE html>
<html lang="es">
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <title>Menú de Gestión de Citas</title>
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/menu-principal.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <br><br><br>

    <?php
        // Incluir el archivo de conexión a la base de datos Oracle
        include('conexion.php');
        $conexion = conexion();

        session_start();
        $medico_id = $_SESSION['medico_id'];
        $email = $_SESSION['email'];
        echo "<h2>Bienvenido $email</h2>";

    ?>

   

    <h1>Menú de Médico <span class="material-symbols-outlined">
        stethoscope
    </span></h1>
    <div class="opcion">
        <a href="fun-medico/ver-citas.php">Ver todas sus citas
            <span class="material-symbols-outlined">event_note</span>
        </a>

        <a href="fun-medico/completar-citas.php">Finalizar citas pendientes 
            <span class="material-symbols-outlined">check</span>
        </a>

        <a href="index.html">Volver al menú principal <span class="material-symbols-outlined">
                home
            </span></a>
    </div>
</body>
</html>