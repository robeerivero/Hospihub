@extends('layouts.app')

@section('content')
<h1>Lista de departamentos</h1>
<table class="table">
    <thead>
        <tr>
            <th>Nombre Departamento</th>
            <th>Ubicación</th>
            <th>Hospital</th>
            <th>Ciudad</th>
            <th>Calle</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departamentos as $row)
        <tr>
            <td>{{ $row->Nombre_departamento }}</td>
            <td>{{ $row->Ubicacion_departamento }}</td>
            <td>{{ $row->Nombre_hospital }}</td>
            <td>{{ $row->Ciudad_hospital }}</td>
            <td>{{ $row->Calle_hospital }}</td>
            <td>
                <a href="#formulario" onclick="rellenarFormulario('{{ $row->Nombre_hospital }}', '{{ $row->Nombre_departamento }}')">Seleccionar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<h2>Buscar Citas Disponibles</h2>
<form action="{{ route('paciente.buscar-citas') }}" method="POST" id="formulario">
    @csrf
    <input type="hidden" name="id_paciente" value="{{ $idPaciente }}">
    
    <label for="hospital">Hospital:</label>
    <input type="text" name="hospital" id="hospital" required>

    <label for="departamento">Departamento:</label>
    <input type="text" name="departamento" id="departamento" required>

    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" id="fecha" min="{{ now()->toDateString() }}" required>

    <button type="submit">Buscar Cita</button>
</form>

<script>
    function rellenarFormulario(hospital, departamento) {
        document.getElementById('hospital').value = hospital;
        document.getElementById('departamento').value = departamento;
        document.getElementById('fecha').focus();
    }
</script>

<a href="{{ route('paciente.menu') }}">Regresar al menú del paciente</a>
@endsection
