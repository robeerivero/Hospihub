<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Citas Disponibles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">

    <!-- Fonts y CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/citas-disponibles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>

    <div id="contenedor" class="container my-5">
        <h1 class="text-center mb-4">Citas Disponibles</h1>

        <div class="info-busqueda text-center mb-5">
            <h2>Hospital: {{ $hospital }}</h2>
            <h2>Departamento: {{ $departamento }}</h2>
            <h2>Fecha: {{ $fecha }}</h2>
        </div>

        @if(count($citas))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Médico</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->Fecha }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->Hora_Cita)->format('H:i') }}</td>
                            <td>{{ $cita->Nombre_Medico }}</td>
                            <td>
                                <form action="{{ route('paciente.citas.seleccionar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cita_id" value="{{ $cita->Id_Cita }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Seleccionar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No hay citas disponibles para los criterios seleccionados.</p>
        @endif
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('menu_paciente') }}" class="btn btn-outline-primary">
            <span class="material-symbols-outlined">arrow_left_alt</span> Volver al menú
        </a>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
