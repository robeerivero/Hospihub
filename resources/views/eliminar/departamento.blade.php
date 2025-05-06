<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Eliminar Departamento</title>
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
    </style>
</head>
<body>
<header>
    <nav>
        <div id="logo"></div>
    </nav>
</header>

<div id="contenedor">
    <h1>Eliminar Departamento</h1>

    @if (session('mensaje'))
        <div class="mensaje-{{ session('tipo') }}">
            {{ session('mensaje') }}
        </div>
    @endif

    <form method="POST" action="{{ route('departamentos.eliminar') }}">
        @csrf
        <div class="form-group">
            <label for="id_departamento">ID del departamento a eliminar:</label>
            <input type="number" name="id_departamento" id="id_departamento" required min="1">
        </div>
        <button type="submit" class="btn-eliminar">Eliminar Departamento</button>
    </form>
</div>

<a href="{{ url('/menu-admin') }}" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>
</body>
</html>
