<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Menú de Admnistradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

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

    <div class="text-center p-5 bg-white shadow rounded w-50">
        <h1 class="mb-3">Bienvenido, Admin 👑 </h1>
        <p class="mb-4">Selecciona una opción de gestión: </p>

        <h3 class="mt-4">🗑️ Eliminar registros</h3>
        <div class="d-grid gap-3">
            <a href="{{ route('hospitales.eliminar.form') }}" class="btn btn-danger">🏥 Eliminar Hospital</a>
            <a href="{{ route('medicos.eliminar.form') }}" class="btn btn-danger">👨‍⚕️ Eliminar Médico</a>
            <a href="{{ route('pacientes.eliminar.form') }}" class="btn btn-danger">🧑‍⚕️ Eliminar Paciente</a>
            <a href="{{ route('departamentos.eliminar.form') }}" class="btn btn-danger">📍 Eliminar Departamento</a>
        </div>

        <h3 class="mt-4">➕ Insertar registros</h3>
        <div class="d-grid gap-3">
            <a href="{{ route('hospitales.insertar.form') }}" class="btn btn-success">🏥 Insertar Hospital</a>
            <a href="{{ route('medicos.insertar.form') }}" class="btn btn-success">👨‍⚕️ Insertar Médico</a>
            <a href="{{ route('departamentos.insertar.form') }}" class="btn btn-success">📍 Insertar Departamento</a>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-secondary">❌ Cerrar Sesión</button>
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