@extends('layouts.admin')

@section('content')
<h1>Listado de Citas</h1>

@if(count($citas) > 0)
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Fecha</th><th>Hora</th><th>Paciente</th><th>Médico</th><th>Departamento</th><th>Hospital</th><th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $cita->Id_Cita }}</td>
                    <td>{{ $cita->Fecha }}</td>
                    <td>{{ $cita->Hora }}</td>
                    <td>{{ $cita->Nombre_Paciente }} {{ $cita->Apellido_Paciente }}</td>
                    <td>{{ $cita->Nombre_Medico }} {{ $cita->Apellidos_Medico }}</td>
                    <td>{{ $cita->Nombre_Departamento }}</td>
                    <td>{{ $cita->Nombre_Hospital }}</td>
                    <td>{{ $cita->Estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No hay citas programadas.</p>
@endif
@endsection
