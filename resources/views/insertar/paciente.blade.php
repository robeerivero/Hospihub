<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Registrar Paciente</title>
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        .mensaje-exito {
            color: #2e7d32;
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 4px;
            border-left: 5px solid #2e7d32;
            margin-bottom: 20px;
        }
        .mensaje-error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 15px;
            border-radius: 4px;
            border-left: 5px solid #d32f2f;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group label {
            width: 180px;
            margin-right: 10px;
            font-weight: bold;
        }

        .form-group input[type="text"], .form-group input[type="date"], .form-group input[type="password"], .form-group input[type="email"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #f0f4f8;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2196f3;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Registrar Paciente <span class="material-symbols-outlined">personal_injury</span></h1>

    @if (session('mensaje'))
        <div class="mensaje-{{ session('tipo') }}">
            {{ session('mensaje') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pacientes.insertar') }}">
        @csrf

        <div class="form-group">
            <label for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" id="Nombre" required value="{{ old('Nombre') }}">
        </div>

        <div class="form-group">
            <label for="Apellidos">Apellidos:</label>
            <input type="text" name="Apellidos" id="Apellidos" required value="{{ old('Apellidos') }}">
        </div>

        <div class="form-group">
            <label for="Telefono">Teléfono:</label>
            <input type="text" name="Telefono" id="Telefono" required value="{{ old('Telefono') }}">
        </div>

        <div class="form-group">
            <label for="Fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="Fecha_nacimiento" id="Fecha_nacimiento" required value="{{ old('Fecha_nacimiento') }}">
        </div>

        <div class="form-group">
            <label for="Ciudad">Ciudad:</label>
            <input type="text" name="Ciudad" id="Ciudad" required value="{{ old('Ciudad') }}">
        </div>

        <div class="form-group">
            <label for="Calle">Calle:</label>
            <input type="text" name="Calle" id="Calle" required value="{{ old('Calle') }}">
        </div>

        <div class="form-group">
            <label for="Email">Email:</label>
            <input type="email" name="Email" id="Email" required value="{{ old('Email') }}">
        </div>

        <div class="form-group">
            <label for="PIN">PIN:</label>
            <input type="password" name="PIN" id="PIN" required value="{{ old('PIN') }}">
        </div>

        <button type="submit">Registrar Paciente</button>
    </form>
</div>

<a href="{{ url('/menu_admin') }}" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>

</body>
</html>
