<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Bienvenido a HospiHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

    <!-- Notificación (Toast) -->
    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="logoutToast" class="toast show align-items-center text-white bg-primary border-0" role="alert">
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
        <h1 class="mb-3">🏥 Bienvenido a HospiHub!</h1>
        <p class="lead">Tu plataforma de gestión de salud.</p>
        <p class="mb-4">Accede a tu cuenta o registrate para comenzar.</p>

        <a href="{{ route('login') }}" class="btn btn-secondary">Iniciar Sesión</a>
        <a href="{{ route('registro') }}" class="btn btn-primary">Registrarse como Paciente</a>
    </div>

    @include('components.covid_button')

    <!-- Script para mostrar el Toast automáticamente -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastNoti = document.getElementById('logoutToast');
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
