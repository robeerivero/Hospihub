<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Lista de Hospitales</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
    <style>
    th:last-child, td:last-child {
        width: 1%;
        white-space: nowrap;
        padding: 6px;
    }
    .btn-accion {
        display: inline-block;
        padding: 4px 8px;
        font-size: 14px;
        background: #58ec54;
        color: white;
        text-decoration: none;
        border-radius: 3px;
        transition: background 0.3s;
        margin: 2px;
    }
    .btn-accion:hover {
        background: #45c042;
    }
</style>

</head>
<body>
    <header><nav><div id="logo">HospiHub</div></nav></header>
    <br><br><br><br>
    <h1>Lista de Hospitales del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Hospital</th>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Calle</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hospitales as $hosp)
                <tr align="center">
                    <td>{{ $hosp->Id_hospital }}</td>
                    <td>{{ $hosp->Nombre_hospital }}</td>
                    <td>{{ $hosp->Ciudad_hospital }}</td>
                    <td>{{ $hosp->Calle_hospital }}</td>
                    <td>
                        <a href="{{ url('/editar/editar-hospital/' . $hosp->Id_hospital) }}" class="btn-accion">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/menu-admin') }}">
        Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span>
    </a>
</body>
</html>
