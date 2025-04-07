<?php
session_start();
include('../conexion.php');
$conexion = conexion();

$mensaje = '';
$tipo_mensaje = ''; // 'exito' o 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email_paciente'])) {
    $email_paciente = $_POST['email_paciente'];

    // Preparar la llamada a la función Eliminar_Paciente
    $query = "CALL Eliminar_Paciente(?)";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Bind del parámetro email_paciente
        $stmt->bind_param("s", $email_paciente);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el resultado de la función
            $stmt->bind_result($resultado);
            if ($stmt->fetch()) {
                $mensaje = $resultado;
                $tipo_mensaje = ($mensaje === 'Paciente eliminado correctamente') ? 'exito' : 'error';
            } else {
                $mensaje = "No se recibió respuesta de la función.";
                $tipo_mensaje = 'error';
            }
        } else {
            $mensaje = "Error al ejecutar la consulta.";
            $tipo_mensaje = 'error';
        }

        $stmt->close();
    } else {
        $mensaje = "Error al preparar la consulta.";
        $tipo_mensaje = 'error';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>
    <title>HospiHub - Eliminar Paciente</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/registro.css">
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

        input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    </style>
</head>
<body>

<header>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<div id="contenedor">
    <h1>Eliminar Paciente</h1>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje-<?php echo $tipo_mensaje; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="formulario">
        <div class="form-group">
            <label for="email_paciente">Email del paciente a eliminar:</label>
            <input type="email" name="email_paciente" id="email_paciente" required>
        </div>
        <button type="submit" class="btn-eliminar">Eliminar Paciente</button>
    </form>
</div>

<a href="../menu-admin.php" class="btn-volver">
    Regresar al menú del administrador
    <span class="material-symbols-outlined">arrow_left_alt</span>
</a>

</body>
</html>
