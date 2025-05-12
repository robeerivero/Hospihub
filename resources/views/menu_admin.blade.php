<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Menú de Administradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link href="{{ asset('css/menu1.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">

</head>
<body class="bg-light">

    <!-- Notificación (Toast) -->
    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="loginToast" class="toast show align-items-center text-white bg-primary border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <header>
        <nav>
        <div id="logo">
            <a href="{{ route('menu_admin') }}" style="color: white; text-decoration: none;">HospiHub</a>
        </div>
    </nav>
    </header>
    <br>
    <h1 class="text-center mt-4">Bienvenido, Admin 👑</h1>

    <div class="grid-container">
        <!-- Ver registros -->
        <div class="box">
            <h3>👀 Ver registros</h3>
            <div class="btn-group">
                <a href="{{ route('hospitales.index') }}" class="btn btn-info">🏥 Hospitales</a>
                <a href="{{ route('medicos.index') }}" class="btn btn-info">👨‍⚕️ Médicos</a>
                <a href="{{ route('paciente.index') }}" class="btn btn-info">🧑‍⚕️ Pacientes</a>
                <a href="{{ route('departamentos.index') }}" class="btn btn-info">📍 Departamentos</a>
            </div>
        </div>

        <!-- Insertar registros -->
        <div class="box">
            <h3>➕ Insertar registros</h3>
            <div class="btn-group">
                <a href="{{ route('hospitales.insertar.form') }}" class="btn btn-success">🏥 Hospital</a>
                <a href="{{ route('medicos.insertar.form') }}" class="btn btn-success">👨‍⚕️ Médico</a>
                <a href="{{ route('pacientes.insertar.form') }}" class="btn btn-success">👨‍⚕️ Paciente</a>
                <a href="{{ route('departamentos.insertar.form') }}" class="btn btn-success">📍 Departamento</a>
            </div>
        </div>

        <!-- Eliminar registros -->
        <div class="box">
            <h3>🗑️ Eliminar registros</h3>
            <div class="btn-group">
                <a href="{{ route('hospitales.eliminar.form') }}" class="btn btn-danger">🏥 Hospital</a>
                <a href="{{ route('medicos.eliminar.form') }}" class="btn btn-danger">👨‍⚕️ Médico</a>
                <a href="{{ route('pacientes.eliminar.form') }}" class="btn btn-danger">🧑‍⚕️ Paciente</a>
                <a href="{{ route('departamentos.eliminar.form') }}" class="btn btn-danger">📍 Departamento</a>
            </div>
        </div>

        <!-- Gestionar Citas -->
        <div class="box">
            <h3>📅 Gestionar Citas</h3>
            <div class="btn-group">
                <a href="{{ route('admin.citas.progreso') }}" class="btn btn-primary">➕ Crear Citas</a>
                <a href="{{ route('admin.citas.progreso_eliminar') }}" class="btn btn-warning">🗑 Eliminar Citas</a>
            </div>
        </div>
    </div>

    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">❌ Cerrar Sesión</button>
        </form>
    </div>

    <!-- Script para mostrar el Toast automáticamente -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastNoti = document.getElementById('loginToast');
            if(toastNoti) {
                var toast = new bootstrap.Toast(toastNoti);
                toast.show();
                setTimeout(() => toast.hide(), 4000);   // Se oculta después de 4 segundos
            }
        });
    </script>

    <!-- Bootstrap JS para controlar el Toast -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
