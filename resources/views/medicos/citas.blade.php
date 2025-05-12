<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Todas mis citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <h1>📅 Todas mis citas</h1>

    <!-- Mensaje de éxito/error -->
    @if(session('mensaje'))
        <p class="{{ session('tipo') }}">{{ session('mensaje') }}</p>
    @endif

    @if(count($citas) > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ $cita->Fecha }}</td>
                        <td>{{ $cita->Hora_Cita }}</td>
                        <td>{{ $cita->Nombre_Paciente }} {{ $cita->Apellidos_Paciente }}</td>
                        <td>
                            <a href="{{ route('medico.citas.diagnostico.form', $cita->Id_Cita) }}">📝 Añadir diagnóstico</a>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    @else
        <p>No tienes citas asignadas.</p>
    @endif

    <a href="{{ route('menu_medico') }}">🏠 Volver al menú</a>

</body>
</html>

