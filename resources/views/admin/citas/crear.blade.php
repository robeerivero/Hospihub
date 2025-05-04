@extends('layouts.admin')

@section('content')
<h1>Resultado al crear todas las citas</h1>

@foreach ($mensajes as $mensaje)
    @if(isset($mensaje->Resultado))
        <div class="success-message">{{ $mensaje->Resultado }}</div>
    @elseif(isset($mensaje->mensaje_error))
        <div class="error-message">{{ $mensaje->mensaje_error }}</div>
    @endif
@endforeach

<a href="{{ route('admin.citas.index') }}">Volver al listado</a>
@endsection
