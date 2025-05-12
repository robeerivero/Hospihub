<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Médico</title>
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
        <h1>Editar Datos del Médico</h1>
        
        <!-- Mostrar mensaje de error o éxito -->
        @if(session('mensaje'))
            <p style="color: {{ session('tipo') == 'exito' ? 'green' : 'red' }}; text-align: center;">
                {!! session('mensaje') !!}
            </p>
        @endif


        <form action="{{ route('medicos.editar', $medico->Id_medico) }}" method="POST">
            @csrf
            <label for="nombre">Nombre</label><br>
            <input type="text" id="nombre" name="nombre" value="{{ $medico->Nombre }}" required><br><br>

            <label for="apellidos">Apellidos</label><br>
            <input type="text" id="apellidos" name="apellidos" value="{{ $medico->Apellidos }}" required><br><br>

            <label for="telefono">Teléfono</label><br>
            <input type="text" id="telefono" name="telefono" value="{{ $medico->Telefono }}" required><br><br>

            <label for="fecha_nacimiento">Fecha de nacimiento</label><br>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $medico->Fecha_nacimiento }}" required><br><br>

            <label for="ciudad">Ciudad</label><br>
            <input type="text" id="ciudad" name="ciudad" value="{{ $medico->Ciudad }}" required><br><br>

            <label for="calle">Calle</label><br>
            <input type="text" id="calle" name="calle" value="{{ $medico->Calle }}" required><br><br>

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="{{ $medico->Email }}" required><br><br>

            <label for="pin">Pin</label><br>
            <input type="password" id="PIN" name="PIN" placeholder="Introduce nuevo PIN (opcional)"><br><br>

            <label for="departamento">Departamento</label><br>
            <input type="text" id="departamento" name="departamento" value="{{ $medico->Nombre_departamento }}" required><br><br>

            <label for="hospital">Hospital</label><br>
            <input type="text" id="hospital" name="hospital" value="{{ $medico->Nombre_hospital }}" required><br><br>

            <button type="submit">Guardar Cambios</button>
        </form>

        <a href="{{ route('medicos.index') }}">Volver a la lista de médicos</a>
    </div>
</body>
</html>
