<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Departamento</title>
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>
<body>
    <header>
        <nav><div id="logo">HospiHub</div></nav>
    </header>

    <div id="contenedor">
        <h1>Editar Datos del Departamento</h1>

        <!-- Mostrar mensaje de éxito o error si está presente -->
        @if(session('mensaje'))
            <p style="color: {{ session('tipo') == 'exito' ? 'green' : 'red' }}; text-align: center;">
                {!! session('mensaje') !!}
            </p>
        @endif

        <form action="{{ route('departamentos.editar', $departamento->Id_departamento) }}" method="POST">
            @csrf
            <label for="nombre_hospital">Nombre del hospital</label><br>
            <input type="text" id="nombre_hospital" name="nombre_hospital" value="{{ $departamento->Nombre_hospital }}" required><br><br>

            <label for="nombre">Nombre del Departamento</label><br>
            <input type="text" id="nombre" name="nombre" value="{{ $departamento->Nombre_departamento }}" required><br><br>

            <label for="ubicacion">Ubicación</label><br>
            <input type="text" id="ubicacion" name="ubicacion" value="{{ $departamento->Ubicacion_departamento }}" required><br><br>

            <button type="submit">Guardar Cambios</button>
        </form>

        <a href="{{ route('departamentos.index') }}">Volver a la lista de departamentos</a>
    </div>
</body>
</html>
