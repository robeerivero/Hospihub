<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Añadir diagnóstico</title>

    <!-- Fuente Rubik -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app-medico.css') }}">

</head>
<body>

<nav>
    <div id="logo">HospiHub</div>
</nav>

<div class="container mt-5">
    <h1>📝 Añadir diagnóstico</h1>

    <div class="form-container">
        <p><strong>Paciente:</strong> {{ $cita->paciente_nombre }}</p>
        <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
        <p><strong>Hora:</strong> {{ $cita->hora }}</p>

        <form action="{{ route('medico.citas.diagnostico', $cita->id) }}" method="POST">
            @csrf

            <label for="descripcion">Diagnóstico:</label>
            <textarea name="descripcion" rows="5" required>{{ $cita->diagnostico_descripcion ?? '' }}</textarea>

            <label for="recomendacion">Recomendación (opcional):</label>
            <textarea name="recomendacion" rows="3">{{ $cita->diagnostico_recomendacion ?? '' }}</textarea>

            <h2 class="mt-4">💊 Medicamentos</h2>
            <div id="medicamentos">
                @if(isset($cita->medicamentos) && count($cita->medicamentos) > 0)
                    @foreach($cita->medicamentos as $medicamento)
                        <div class="medicamento">
                            <input type="text" name="nombre_medicamento[]" value="{{ $medicamento->Nombre }}" placeholder="Nombre del medicamento">
                            <input type="text" name="frecuencia[]" value="{{ $medicamento->Frecuencia }}" placeholder="Frecuencia">
                        </div>
                    @endforeach
                @else
                    <div class="medicamento">
                        <input type="text" name="nombre_medicamento[]" placeholder="Nombre del medicamento">
                        <input type="text" name="frecuencia[]" placeholder="Frecuencia">
                    </div>
                @endif
            </div>

            <button type="button" class="btn-add" id="btnAgregar">➕ Añadir medicamento</button>
            <br>
            <button type="submit" class="btn btn-primary">✅ Guardar diagnóstico</button>
        </form>

        <a href="{{ route('menu_medico') }}" class="btn-outline-primary mt-4">🏠 Volver al menú</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contenedor = document.getElementById('medicamentos');
        const boton = document.getElementById('btnAgregar');

        boton.addEventListener('click', function () {
            const div = document.createElement('div');
            div.className = 'medicamento';
            div.innerHTML = `
                <input type="text" name="nombre_medicamento[]" placeholder="Nombre del medicamento">
                <input type="text" name="frecuencia[]" placeholder="Frecuencia">
            `;
            contenedor.appendChild(div);
        });
    });
</script>

</body>
</html>
