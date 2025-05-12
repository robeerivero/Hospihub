<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Insertar Departamento</title>
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
            width: 180px; /* Ajusta según lo largo del texto más largo */
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
    <h1>Registrar Departamento <span class="material-symbols-outlined">business</span></h1>

    @if (session('mensaje'))
        <div class="mensaje-{{ session('tipo') }}">
            {{ session('mensaje') }}
        </div>
    @endif

    <form method="POST" action="{{ route('departamentos.insertar') }}">
        @csrf

        <div class="form-group">
            <label for="nombre_hospital">Nombre del hospital:</label>
            <input type="text" name="nombre_hospital" id="nombre_hospital" required value="{{ old('nombre_hospital') }}">
        </div>
        <br \>
        <div class="form-group">
            <label for="nombre_departamento">Nombre del departamento:</label>
            <input type="text" name="nombre_departamento" id="nombre_departamento" required>
        </div>        
        <br \>
        <div class="form-group">
            <label for="ubicacion">Ubicación:</label>
            <input type="text" name="ubicacion" id="ubicacion" required value="{{ old('ubicacion') }}">
        </div>

        <button type="submit">Registrar Departamento</button>
    </form>
</div>

<a href="{{ url('/menu_admin') }}" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>
</body>
</html>
