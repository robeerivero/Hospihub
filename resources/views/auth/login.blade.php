<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Iniciar Sesión - HospiHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="p-4 bg-white shadow rounded w-25">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('Email')}}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="Email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="Email" required>
            </div>
            <div class="mb-3">
                <label for="PIN" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="PIN" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <p class="mt-3 text-center">
            ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>
