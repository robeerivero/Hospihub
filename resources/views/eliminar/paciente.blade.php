<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Eliminar Paciente</title>
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
            margin-bottom: 20px;
        }

        input[type="email"] {
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
    <h1>Eliminar Paciente</h1>

    @if (session('mensaje'))
        <div class="mensaje-{{ session('tipo') }}">
            {{ session('mensaje') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pacientes.eliminar') }}">
        @csrf
        <div class="form-group">
            <label for="email_paciente">Email del paciente a eliminar:</label>
            <input type="email" name="email_paciente" id="email_paciente" required>
        </div>
        <button type="submit" class="btn-eliminar">Eliminar Paciente</button>
    </form>
</div>

<a href="{{ url('/menu_admin') }}" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>

</body>
</html>
