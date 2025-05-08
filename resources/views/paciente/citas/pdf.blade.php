<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Cita</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1, h2 { text-align: center; }
        p { margin: 5px 0; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: center; }
    </style>
</head>
<body>
    <h1>Detalles de la Cita</h1>

    <h2>Información de la Cita</h2>
    <p><strong>Fecha:</strong> {{ $cita->Fecha }}</p>
    <p><strong>Hora:</strong> {{ $cita->Hora }}</p>
    <p><strong>Médico:</strong> Dr. {{ $cita->Nombre_Medico }} {{ $cita->Apellidos_Medico }}</p>
    <p><strong>Departamento:</strong> {{ $cita->Departamento }}</p>
    <p><strong>Hospital:</strong> {{ $cita->Hospital }}</p>

    <h2>Diagnóstico</h2>
    @if($diagnostico)
        <p><strong>Descripción:</strong> {{ $diagnostico->Descripcion }}</p>
        <p><strong>Recomendaciones:</strong> {{ $diagnostico->Recomendacion }}</p>
    @else
        <p>No se encontró diagnóstico.</p>
    @endif

    <h2>Medicamentos Recetados</h2>
    @if(count($medicamentos))
        <table>
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
        <p>No hay medicamentos recetados.</p>
    @endif
</body>
</html>
