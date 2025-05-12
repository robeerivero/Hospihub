@extends('layouts.admin')

@section('content')
<h1>Eliminar todas las citas</h1>

<div class="warning-message">
    Se han eliminado todas las citas.
</div>

<a href="{{ route('menu_admin') }}">Volver al listado</a>
@endsection
