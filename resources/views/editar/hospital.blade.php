<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hospital</title>
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>
<body>
    <header>
        <nav><div id="logo">HospiHub</div></nav>
    </header>

    <div id="contenedor">
        <h1>Editar Datos del Hospital</h1>
        
        <!-- Mostrar mensaje si hay -->
        @if(session('mensaje'))
            <p style="color: green; text-align: center;">{{ session('mensaje') }}</p>
        @endif

        <form action="{{ route('hospitales.editar', $hospital->Id_hospital) }}" method="POST">
            @csrf
            <label for="nombre">Nombre del Hospital</label><br>
            <input type="text" id="nombre" name="nombre" value="{{ $hospital->Nombre_hospital }}" required><br><br>

            <label for="ciudad">Ciudad</label><br>
            <input type="text" id="ciudad" name="ciudad" value="{{ $hospital->Ciudad_hospital }}" required><br><br>

            <label for="calle">Calle</label><br>
            <input type="text" id="calle" name="calle" value="{{ $hospital->Calle_hospital }}" required><br><br>

            <button type="submit">Guardar Cambios</button>
        </form>

        <a href="{{ route('hospitales.index') }}">Volver a la lista de hospitales</a>
    </div>
</body>
</html>
