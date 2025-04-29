<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->

    <title>HospiHub - Menú principal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">

    <!-- Google Fonts y estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/menu-principal.css') }}">

</head>
<body>
    <header>   
        <nav>
            <div id="logo"><a href="{{ url('/') }}">HospiHub</a></div>
        </nav>
    </header>

    <h2>--------------- Iniciar Sesión ---------------</h2>
    <div class="opcion">
        <a href="{{ url('login/login-paciente') }}">Iniciar sesión como paciente
            <span class="material-symbols-outlined">personal_injury</span>
        </a>
        <a href="{{ url('login/login-medico') }}">Iniciar sesión como médico
            <span class="material-symbols-outlined">stethoscope</span>
        </a>
        <a href="{{ url('login/login-admin') }}">Iniciar sesión como admin
            <span class="material-symbols-outlined">admin_panel_settings</span>
        </a>
    </div>

    <h2>--------------- Registrarse ---------------</h2>
    <div class="opcion">
        <a href="{{ url('insertar-register/register-paciente') }}">Registrarse como paciente
            <span class="material-symbols-outlined">personal_injury</span>
        </a>
    </div>
</body>
</html>
