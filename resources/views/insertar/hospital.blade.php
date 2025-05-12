<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Insertar Hospital</title>
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

        .form-group input[type="text"] {
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
        <div id="logo">
            <a href="{{ route('menu_admin') }}" style="color: white; text-decoration: none;">HospiHub</a>
        </div>
    </nav>
    </header>

<div id="contenedor">
    <h1>Registrar Hospital <span class="material-symbols-outlined">local_hospital</span></h1>

    @if (session('mensaje'))
        <div class="mensaje-{{ session('tipo') }}">
            {{ session('mensaje') }}
        </div>
    @endif

    <form method="POST" action="{{ route('hospitales.insertar') }}">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre del hospital:</label>
            <input type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}">
        </div>

        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" name="ciudad" id="ciudad" required value="{{ old('ciudad') }}">
        </div>

        <div class="form-group">
            <label for="calle">Calle:</label>
            <input type="text" name="calle" id="calle" required value="{{ old('calle') }}">
        </div>

        <button type="submit">Registrar Hospital</button>
    </form>
</div>

<a href="{{ url('/menu_admin') }}" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>
</body>
</html>
