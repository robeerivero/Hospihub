<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>
<body>
    <header>
        <nav>
        <div id="logo">
            <a href="{{ route('menu_admin') }}" style="color: white; text-decoration: none;">HospiHub</a>
        </div>
    </nav>
    </header>

    <div id="contenedor">
        <h1>Editar Datos del Paciente</h1>

        @if(session('mensaje'))
            <p style="color: {{ session('tipo') == 'exito' ? 'green' : 'red' }}; text-align: center;">
                {{ session('mensaje') }}
            </p>
        @endif

        <form action="{{ route('pacientes.editar', $paciente->Id_paciente) }}" method="POST">
            @csrf

            <label for="Nombre">Nombre</label><br>
            <input type="text" id="Nombre" name="Nombre" value="{{ $paciente->Nombre }}" required><br><br>

            <label for="Apellidos">Apellidos</label><br>
            <input type="text" id="Apellidos" name="Apellidos" value="{{ $paciente->Apellidos }}" required><br><br>

            <label for="Telefono">Teléfono</label><br>
            <input type="text" id="Telefono" name="Telefono" value="{{ $paciente->Telefono }}" required><br><br>

            <label for="Fecha_nacimiento">Fecha de nacimiento</label><br>
            <input type="date" id="Fecha_nacimiento" name="Fecha_nacimiento" value="{{ $paciente->Fecha_nacimiento }}" required><br><br>

            <label for="Ciudad">Ciudad</label><br>
            <input type="text" id="Ciudad" name="Ciudad" value="{{ $paciente->Ciudad }}" required><br><br>

            <label for="Calle">Calle</label><br>
            <input type="text" id="Calle" name="Calle" value="{{ $paciente->Calle }}" required><br><br>

            <label for="Email">Email</label><br>
            <input type="email" id="Email" name="Email" value="{{ $paciente->Email }}" required><br><br>

            <label for="PIN">PIN</label><br>
            <input type="password" id="PIN" name="PIN" placeholder="Introduce nuevo PIN (opcional)">

            <button type="submit">Guardar Cambios</button>
        </form>

        <a href="{{ route('paciente.index') }}">Volver a la lista de pacientes</a>
    </div>
</body>
</html>
