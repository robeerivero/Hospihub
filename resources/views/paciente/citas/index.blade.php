<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Tus Citas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Roberto Rivero Díaz, Jesús Gallego Ibáñez, David Conde Salado">

    <!-- Fonts y CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/ver-citas.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>

    <div id="contenedor" class="container my-5">
        <h1 class="text-center mb-4" style="color: black;">Tus Citas</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(count($citas))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Médico</th>
                        <th>Departamento</th>
                        <th>Hospital</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->Fecha }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->Hora)->format('H:i') }}</td>
                            <td>{{ $cita->Nombre_Medico }} {{ $cita->Apellidos_Medico }}</td>
                            <td>{{ $cita->Nombre_Departamento }}</td>
                            <td>{{ $cita->Nombre_Hospital }}</td>
                            <td>{{ $cita->Estado }}</td>
                            <td>
                                @if($cita->Estado === 'Diagnostico Completo')
                                    <a href="{{ route('paciente.citas.show', $cita->Id_Cita) }}" class="btn btn-info btn-sm">Ver diagnóstico</a>
                                @elseif($cita->Estado === 'Paciente Asignado')
                                    <form action="{{ route('paciente.citas.cancelar') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="cita_id" value="{{ $cita->Id_Cita }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No tienes citas programadas.</p>
        @endif
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('menu_paciente') }}" id="volver" class="btn btn-outline-primary">
            Volver al menú de paciente 
            <span class="material-symbols-outlined">home</span>
        </a>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
