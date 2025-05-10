<!DOCTYPE html>
<html lang="es">
<head>
    <!--           ConveyThis Script Start         -->
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <!--           ConveyThis Script End         -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Añadir diagnóstico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>📝 Añadir diagnóstico</h1>

    <p><strong>Paciente:</strong> {{ $cita->paciente_nombre }}</p>
    <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
    <p><strong>Hora:</strong> {{ $cita->hora }}</p>

    <form action="{{ route('medico.citas.diagnostico', $cita->id) }}" method="POST">
        @csrf
        <label for="descripcion">Diagnóstico:</label>
        <textarea name="descripcion" rows="5" required>{{ $cita->diagnostico_descripcion ?? '' }}</textarea>

        <label for="recomendacion">Recomendación (Opcional):</label>
        <textarea name="recomendacion" rows="3">{{ $cita->diagnostico_recomendacion ?? '' }}</textarea>

        <h3>💊 Medicamentos (Opcional)</h3>
        <div id="medicamentos">
            @if(isset($cita->medicamentos) && count($cita->medicamentos) > 0)
                @foreach($cita->medicamentos as $medicamento)
                    <div class="medicamento">
                        <input type="text" name="nombre_medicamento[]" value="{{ $medicamento->nombre }}" placeholder="Nombre del medicamento">
                        <input type="text" name="frecuencia[]" value="{{ $medicamento->frecuencia }}" placeholder="Frecuencia">
                    </div>
                @endforeach
            @else
                <div class="medicamento">
                    <input type="text" name="nombre_medicamento[]" placeholder="Nombre del medicamento">
                    <input type="text" name="frecuencia[]" placeholder="Frecuencia">
                </div>
            @endif
        </div>

        <button type="submit">✅ Guardar diagnóstico</button>
    </form>

    <a href="{{ route('menu_medico') }}">🏠 Volver al menú</a>

</body>
</html>
