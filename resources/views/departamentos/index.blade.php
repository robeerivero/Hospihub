<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Lista de Departamentos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
    <style>
        .table {
            width: 90%;
        }
    </style>
</head>
<body>
    <header><nav><div id="logo">HospiHub</div></nav></header>
    <br><br><br><br>
    <h1>Lista de Departamentos del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id Departamento</th>
                <th>Nombre Departamento</th>
                <th>Ubicación</th>
                <th>Id Hospital</th>
                <th>Nombre Hospital</th>
                <th>Ciudad Hospital</th>
                <th>Calle Hospital</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departamentos as $dep)
                <tr align="center">
                    <td>{{ $dep->Id_departamento }}</td>
                    <td>{{ $dep->Nombre_departamento }}</td>
                    <td>{{ $dep->Ubicacion_departamento }}</td>
                    <td>{{ $dep->Id_hospital }}</td>
                    <td>{{ $dep->Nombre_hospital }}</td>
                    <td>{{ $dep->Ciudad_hospital }}</td>
                    <td>{{ $dep->Calle_hospital }}</td>
                    <td><a href="{{ url('/editar/editar-departamento/' . $dep->Id_departamento) }}" class="btn-accion">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/menu_admin') }}">
        Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>
</body>
</html>
