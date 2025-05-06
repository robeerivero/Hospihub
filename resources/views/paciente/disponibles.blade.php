@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Citas Disponibles</h2>

    @if(count($citas))
        <form action="{{ route('paciente.citas.seleccionar') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Médico</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->Fecha }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->Hora)->format('H:i') }}</td>
                            <td>Dr. {{ $cita->Nombre_Medico }} {{ $cita->Apellidos_Medico }}</td>
                            <td>
                                <button type="submit" name="cita_id" value="{{ $cita->Id_Cita }}" class="btn btn-success btn-sm">Seleccionar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    @else
        <p>No hay citas disponibles con los criterios seleccionados.</p>
    @endif

    <a href="{{ route('paciente.citas.elegir') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
