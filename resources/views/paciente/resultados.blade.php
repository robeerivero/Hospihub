@extends('layouts.app')

@section('content')
    <div class="mt-10 text-center">
        @if($estado === 'success')
            <div style="color: #52ee57;">{{ $mensaje }}</div>
        @else
            <div style="color: red;">{{ $mensaje }}</div>
        @endif
        <br>
        <a href="{{ route('paciente.menu') }}">Regresar al menú del paciente</a>
    </div>
@endsection
