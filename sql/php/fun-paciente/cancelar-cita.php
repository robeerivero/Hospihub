<?php
// Iniciar sesión al principio del script
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_paciente'])) {
    header("Location: ../login/login-paciente.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Cancelar cita</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/reserva.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

<?php
// Verificar que se recibió el ID de la cita
if (!isset($_GET['id_cita']) || !is_numeric($_GET['id_cita'])) {
    echo "<div class='error-message'>";
    echo "<br><br><br><br><br>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "<p style='color:#d32f2f; text-align:center; font-size:1.5em;'>No se especificó una cita válida para cancelar.</p>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "</div>";
    exit();
}

$id_cita = intval($_GET['id_cita']);
$id_paciente = $_SESSION['id_paciente'];

// Conectar a la base de datos usando la función de conexión
include('../conexion.php');
$conexion = conexion();

// Verificar la conexión
if ($conexion->connect_error) {
    echo "<div class='error-message'>";
    echo "<br><br><br><br><br>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "<p style='color:#d32f2f; text-align:center; font-size:1.5em;'>Conexión fallida: " . htmlspecialchars($conexion->connect_error) . "</p>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "</div>";
    exit();
}

// Llamar al procedimiento almacenado para cancelar la cita
$sql = "CALL Cancelar_Cita(?, ?, @resultado)";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo "<div class='error-message'>";
    echo "<br><br><br><br><br>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "<p style='color:#d32f2f; text-align:center; font-size:1.5em;'>Error al preparar la consulta: " . htmlspecialchars($conexion->error) . "</p>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "</div>";
    exit();
}

$stmt->bind_param("ii", $id_cita, $id_paciente);
$stmt->execute();
$stmt->close();

// Obtener el resultado del procedimiento
$result = $conexion->query("SELECT @resultado AS resultado");
$row = $result->fetch_assoc();
$mensaje = $row['resultado'];

// Mostrar el resultado
if (strpos($mensaje, 'correctamente') !== false) {
    echo "<div class='success-message'>";
    echo "<br><br><br><br><br>";
    echo "<hr style='border-top: 3px solid #4CAF50; border-bottom: 3px solid #4CAF50;'>";
    echo "<p style='color:#4CAF50; text-align:center; font-size:1.5em;'>" . htmlspecialchars($mensaje) . "</p>";
    echo "<hr style='border-top: 3px solid #4CAF50; border-bottom: 3px solid #4CAF50;'>";
    echo "</div>";
} else {
    echo "<div class='error-message'>";
    echo "<br><br><br><br><br>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "<p style='color:#d32f2f; text-align:center; font-size:1.5em;'>" . htmlspecialchars($mensaje) . "</p>";
    echo "<hr style='border-top: 3px solid #d32f2f; border-bottom: 3px solid #d32f2f;'>";
    echo "</div>";
}

// Cerrar conexión
$conexion->close();
?> 

<div class="action-buttons">
    <a href="../menu-paciente.php" class="btn-return">Volver al menú principal</a>
    <a href="ver-citas-paciente.php" class="btn-view">Ver mis citas</a>
</div>

</body>
</html>