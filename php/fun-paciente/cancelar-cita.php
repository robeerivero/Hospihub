<!DOCTYPE html>
<html>
<head>
    <title>HospiHub - Cancelar todas las citas</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <meta name="designer" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Enlaces a los archivos CSS -->
    <link rel="stylesheet" href="../css/ver.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

<?php
// Conectar a la base de datos
include('../conexion.php');
$conexion = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el ID de la cita a cancelar de la URL
$id_cita = $_GET['id_cita'];

// Preparar la consulta para actualizar el estado de la cita
$sql = "UPDATE Tabla_Cita SET Id_Paciente = NULL, Estado = 'Paciente sin asignar' WHERE Id_Cita = ?";
$stmt = $conexion->prepare($sql);

// Vincular el parámetro
$stmt->bind_param("i", $id_cita);

// Ejecutar la consulta
$result = $stmt->execute();

if ($result) {
    echo "<br><br><br><br><br><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'><p style='color:red; text-align:center; font-size:1.5em;'>La cita ha sido cancelada correctamente</p><hr style='border-top: 3px solid red; border-bottom: 3px solid red;'>";
} else {
    echo "<h2>Hubo un error al cancelar la cita. Por favor, inténtalo de nuevo.</h2>";
}

// Liberar recursos
$stmt->close();
$conexion->close();
?> 

</body>
</html>
