<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <!-- script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script -->
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Menú de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/menu1.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">

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
        <h1 class="mb-3">Bienvenido, {{ Auth::user()->Nombre }} 👋🏼 </h1>
        <p class="mb-4">Selecciona una opción para gestionar tu cuenta: </p>

        <div class="d-grid gap-3">
            <a href="{{ route('paciente.citas.elegir') }}" class="btn btn-primary">🩺 Pedir Cita</a>
            <a href="{{ route('paciente.citas.index') }}" class="btn btn-success">📅 Gestionar mis Citas</a>

            <form action="{{ route('logout') }}" method='POST' style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">❌ Cerrar Sesión</button>
            </form>
        </div>
    </div>

    @include('components.covid_button')
    
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
