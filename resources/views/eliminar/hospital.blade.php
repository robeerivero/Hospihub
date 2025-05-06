<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Eliminar Hospital</title>
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        .mensaje-exito {
            color: #2e7d32;
            background: #e8f5e9;
            padding: 15px;
            border-radius: 4px;
            border-left: 5px solid #2e7d32;
        }

        .mensaje-error {
            color: #d32f2f;
            background: #ffebee;
            padding: 15px;
            border-radius: 4px;
            border-left: 5px solid #d32f2f;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-eliminar {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-eliminar:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div id="logo"></div>
    </nav>
</header>

<div id="contenedor">
    <h1>Eliminar Hospital</h1>

    @if (session('mensaje'))
        <div class="mensaje-{{ session('tipo') }}">
            {{ session('mensaje') }}
        </div>
    @endif

    <form method="POST" action="{{ route('hospitales.eliminar') }}">
        @csrf
        <div class="form-group">
            <label for="nombre_hospital">Nombre del hospital a eliminar:</label>
            <input type="text" name="nombre_hospital" id="nombre_hospital" required>
        </div>
        <button type="submit" class="btn-eliminar">Eliminar Hospital</button>
    </form>
</div>

<a href="{{ url('/menu-admin') }}" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>

</body>
</html>
