<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HospiHub - Elegir Citas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Roberto Rivero Díaz, Jesús Gallego Ibáñez, David Conde Salado">

    <!-- Fonts y CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>  
    <header>
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <br><br><br><br><br>

    <h1 class="text-center">Lista de departamentos</h1>

    <div class="container my-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre Departamento</th>
                    <th>Ubicación</th>
                    <th>Hospital</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departamentos as $departamento)
                    <tr>
                        <td>{{ $departamento->Nombre }}</td>
                        <td>{{ $departamento->Ubicacion }}</td>
                        <td>{{ $hospitales->firstWhere('Id_hospital', $departamento->Id_hospital)?->Nombre ?? 'Desconocido' }}</td>
                        <td>
                            <a href="#formulario" onclick="rellenarFormulario('{{ $hospitales->firstWhere('Id_hospital', $departamento->Id_hospital)?->Nombre }}', '{{ $departamento->Nombre }}')">
                                Seleccionar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="contenedor" class="container my-5">
        <h2 class="text-center mb-4">Buscar Citas Disponibles</h2>
        <form action="{{ route('paciente.citas.procesar') }}" method="POST" id="formulario" class="p-4 shadow rounded bg-light">
            @csrf

            <div class="mb-3">
                <label for="hospital" class="form-label">Nombre del Hospital:</label>
                <input type="text" id="hospital" name="hospital" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="departamento" class="form-label">Departamento:</label>
                <input type="text" id="departamento" name="departamento" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Buscar Cita</button>
            </div>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('menu_paciente') }}">
            Regresar al menú del paciente 
            <span class="material-symbols-outlined">arrow_left_alt</span>
        </a>
    </div>

    <!-- Scripts -->
    <script>
    function rellenarFormulario(hospital, departamento) {
        document.getElementById('hospital').value = hospital;
        document.getElementById('departamento').value = departamento;
        document.getElementById('fecha').focus();
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
