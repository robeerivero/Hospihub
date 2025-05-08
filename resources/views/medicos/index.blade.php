<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Lista de Médicos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
</head>
<body>
    <header><nav><div id="logo">HospiHub</div></nav></header>
    <br><br><br><br>
    <h1>Lista de Médicos del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Médico</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Fecha de Nacimiento</th>
                <th>Ciudad</th>
                <th>Calle</th>
                <th>Email</th>
                <th>PIN</th>
                <th>Departamento</th>
                <th>Id Departamento</th>
                <th>Hospital</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicos as $med)
                <tr align="center">
                    <td>{{ $med->Id_medico }}</td>
                    <td>{{ $med->Nombre }}</td>
                    <td>{{ $med->Apellidos }}</td>
                    <td>{{ $med->Telefono }}</td>
                    <td>{{ $med->Fecha_nacimiento }}</td>
                    <td>{{ $med->Ciudad }}</td>
                    <td>{{ $med->Calle }}</td>
                    <td>{{ $med->Email }}</td>
                    <td>{{ $med->PIN }}</td>
                    <td>{{ $med->Nombre_departamento }}</td>
                    <td>{{ $med->Id_departamento }}</td>
                    <td>{{ $med->Nombre_hospital }}</td>
                    <td><a href="{{ url('/editar/editar-medico/' . $med->Id_medico) }}" class="btn-accion">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/menu_admin') }}">
        Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>
</body>
</html>
