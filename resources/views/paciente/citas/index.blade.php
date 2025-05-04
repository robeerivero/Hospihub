@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Citas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($citas))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ $cita->Fecha }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->Hora)->format('H:i') }}</td>
                        <td>{{ $cita->Estado }}</td>
                        <td>
                            <a href="{{ route('paciente.citas.show', $cita->Id_Cita) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            @if($cita->Estado === 'Paciente Asignado')
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
        <p>No tienes citas registradas.</p>
    @endif
</div>
@endsection
