@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Cita</h2>

    <p><strong>Fecha:</strong> {{ $cita->Fecha }}</p>
    <p><strong>Hora:</strong> {{ $cita->Hora }}</p>
    <p><strong>Médico:</strong> Dr. {{ $cita->Nombre_Medico }} {{ $cita->Apellidos_Medico }}</p>
    <p><strong>Departamento:</strong> {{ $cita->Departamento }}</p>
    <p><strong>Hospital:</strong> {{ $cita->Hospital }}</p>

    <hr>

    <h4>Diagnóstico</h4>
    @if($diagnostico)
        <p>{{ $diagnostico->Descripcion }}</p>
    @else
        <p>No hay diagnóstico registrado.</p>
    @endif

    <h4>Medicamentos Recetados</h4>
    @if(count($medicamentos))
        <ul>
            @foreach($medicamentos as $med)
                <li>{{ $med->Nombre }} - {{ $med->Dosis }}</li>
            @endforeach
        </ul>
    @else
        <p>No hay medicamentos recetados.</p>
    @endif

    <a href="{{ route('paciente.citas.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
