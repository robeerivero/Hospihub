@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Elegir Cita</h2>

    <form action="{{ route('paciente.citas.procesar') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="hospital">Hospital</label>
            <select name="hospital" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($hospitales as $hospital)
                    <option value="{{ $hospital->Id_Hospital }}">{{ $hospital->Nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="departamento">Departamento</label>
            <select name="departamento" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($departamentos as $departamento)
                    <option value="{{ $departamento->Id_Departamento }}">{{ $departamento->Nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Buscar Citas</button>
    </form>
</div>
@endsection
