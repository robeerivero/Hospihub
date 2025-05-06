<nav>
    <ul>
        <li><a href="{{ url('/') }}">Inicio</a></li>
        <li><a href="{{ route('paciente.citas.index') }}">Mis Citas</a></li>
        <li><a href="{{ route('paciente.citas.elegir') }}">Elegir Fecha</a></li>
        <li><a href="{{ route('admin.citas.index') }}">Admin: Ver Citas</a></li>
    </ul>
</nav>
