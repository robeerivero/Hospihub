<?php
// Iniciar sesión para verificar permisos
session_start();


// Conexión a la base de datos MySQL
include('../conexion.php');
$conexion = conexion();

// Obtener lista de hospitales y departamentos
$hospitales = [];
$departamentos = [];

// Consulta para obtener hospitales
$sql_hospitales = "SELECT Id_hospital, Nombre FROM Hospital ORDER BY Nombre";
$result_hospitales = $conexion->query($sql_hospitales);
if ($result_hospitales) {
    while ($row = $result_hospitales->fetch_assoc()) {
        $hospitales[$row['Id_hospital']] = $row['Nombre'];
    }
}

// Consulta para obtener departamentos con información de hospital
$sql_departamentos = "SELECT d.Id_departamento, d.Nombre AS departamento, h.Nombre AS hospital 
                      FROM Departamento d
                      JOIN Hospital h ON d.Id_hospital = h.Id_hospital
                      ORDER BY h.Nombre, d.Nombre";
$result_departamentos = $conexion->query($sql_departamentos);
if ($result_departamentos) {
    while ($row = $result_departamentos->fetch_assoc()) {
        $departamentos[$row['Id_departamento']] = [
            'nombre' => $row['departamento'],
            'hospital' => $row['hospital']
        ];
    }
}

// Inicializar la variable de mensaje
$mensaje = '';
$tipo_mensaje = ''; // 'exito' o 'error'

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_departamento'])) {
    $id_departamento = intval($_POST['id_departamento']);
    
    // Validar que el departamento existe
    if (!array_key_exists($id_departamento, $departamentos)) {
        $mensaje = 'El departamento seleccionado no existe';
        $tipo_mensaje = 'error';
    } else {
        // Llamar al procedimiento almacenado
        $sql = "CALL Eliminar_Departamento(?)";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id_departamento);
            
            if ($stmt->execute()) {
                // Obtener el resultado
                $result = $stmt->get_result();
                if ($result && $row = $result->fetch_assoc()) {
                    $mensaje = $row['resultado'];
                    $tipo_mensaje = ($mensaje == 'Departamento eliminado correctamente') ? 'exito' : 'error';
                    
                    // Actualizar la lista de departamentos si se eliminó correctamente
                    if ($tipo_mensaje == 'exito') {
                        unset($departamentos[$id_departamento]);
                    }
                }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <title>HospiHub - Eliminar Departamento</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <meta name="designer" content="Carlos Antonio Cortés Lora, Roberto Rivero Díaz">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/register.css">
    <style>
        .mensaje-exito {
            color: #2e7d32;
            background-color: #e8f5e9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
            border-left: 5px solid #2e7d32;
        }
        
        .mensaje-error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
            border-left: 5px solid #d32f2f;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .btn-eliminar {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-eliminar:hover {
            background-color: #d32f2f;
        }
        
        .departamento-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .departamento-info {
            flex-grow: 1;
        }
    </style>
</head>
<body>

<header>   
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Eliminar Departamento</h1>
    
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje-<?php echo $tipo_mensaje; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="formulario">
        <div class="form-group">
            <label for="id_departamento">Seleccione el departamento a eliminar:</label>
            <select id="id_departamento" name="id_departamento" required>
                <option value="">-- Seleccione un departamento --</option>
                <?php foreach ($departamentos as $id => $depto): ?>
                    <option value="<?php echo $id; ?>">
                        <?php echo htmlspecialchars($depto['nombre'] . ' - ' . $depto['hospital']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn-eliminar">Eliminar Departamento</button>
    </form>
    
</div>

<a href="../menu-admin.php" class="btn-volver">Regresar al menú del administrador 
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>

</body>
</html>