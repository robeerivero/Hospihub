<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Lista de Pacientes</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
</head>
<body>
    <header><nav><div id="logo">HospiHub</div></nav></header>
    <br><br><br><br>
    <h1>Lista de Pacientes del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Paciente</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Fecha de Nacimiento</th>
                <th>Ciudad</th>
                <th>Calle</th>
                <th>Email</th>
                <th>PIN</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $pac)
                <tr align="center">
                    <td>{{ $pac->Id_paciente }}</td>
                    <td>{{ $pac->Nombre }}</td>
                    <td>{{ $pac->Apellidos }}</td>
                    <td>{{ $pac->Telefono }}</td>
                    <td>{{ $pac->Fecha_nacimiento }}</td>
                    <td>{{ $pac->Ciudad }}</td>
                    <td>{{ $pac->Calle }}</td>
                    <td>{{ $pac->Email }}</td>
                    <td>{{ $pac->PIN }}</td>
                    <td><a href="{{ url('/editar/editar-paciente/' . $pac->Id_paciente) }}" class="btn-accion">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/menu-admin') }}">
        Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>
</body>
</html>
