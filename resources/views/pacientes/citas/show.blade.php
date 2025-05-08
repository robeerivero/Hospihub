<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Detalles de la Cita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Roberto Rivero Díaz, Jesús Gallego Ibáñez, David Conde Salado">

    <!-- Fonts y CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/detalle-cita.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav>
    <div id="logo">HospiHub</div>
</nav>

<div id="contenedor" class="container my-5">
    <h1 class="text-center mb-4">Detalles de la Cita</h1>

    <div class="info-cita mb-5">
        <h2>Información de la Cita</h2>
        <p><strong>Fecha:</strong> {{ $cita->Fecha }}</p>
        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->Hora)->format('H:i') }}</p>
        <p><strong>Médico:</strong> Dr. {{ $cita->Nombre_Medico }} {{ $cita->Apellidos_Medico }}</p>
        <p><strong>Departamento:</strong> {{ $cita->Departamento }}</p>
        <p><strong>Hospital:</strong> {{ $cita->Hospital }}</p>
    </div>

    <div class="diagnostico-container mb-5">
        <h2>Diagnóstico</h2>
        @if($diagnostico)
            <p><strong>Descripción:</strong><br>{{ $diagnostico->Descripcion }}</p>
            <p><strong>Recomendaciones:</strong><br>{{ $diagnostico->Recomendacion }}</p>
        @else
            <p>No se encontró diagnóstico para esta cita.</p>
        @endif
    </div>

    <div class="medicamentos-container mb-5">
        <h2>Medicamentos Recetados</h2>
        @if(count($medicamentos))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Frecuencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicamentos as $med)
                        <tr>
                            <td>{{ $med->Nombre }}</td>
                            <td>{{ $med->Frecuencia }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No se recetaron medicamentos para esta cita.</p>
        @endif
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('paciente.citas.pdf', $cita->Id_cita) }}" class="btn btn-success">
            <span class="material-symbols-outlined">download</span> Descargar PDF
        </a>
        <a href="{{ route('paciente.citas.index') }}" class="btn btn-outline-primary me-2">
            <span class="material-symbols-outlined">arrow_left_alt</span> Volver a las citas
        </a>
        <a href="{{ route('menu_paciente') }}" class="btn btn-outline-secondary">
            <span class="material-symbols-outlined">home</span> Volver al menú
        </a>
    </div>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
