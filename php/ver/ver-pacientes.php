<?php
include('../conexion.php');
$conexion = conexion();

// Consulta SQL para obtener los pacientes junto con la ciudad y calle de la tabla direccion
$sql = "SELECT p.id_paciente, p.nombre, p.apellidos, p.telefono, p.fecha_nacimiento, d.ciudad, d.calle, p.email, p.pin 
        FROM paciente p
        JOIN direccion d ON p.id_direccion = d.id_direccion";

$result = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiHub - Lista de pacientes</title>
    <link rel="stylesheet" href="../css/ver.css" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <br><br><br><br>
    
    <h1>Lista de Pacientes del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Paciente</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Fecha de Nacimiento</th>
                <th>Ciudad</th>
                <th>Calle</th>
                <th>Email</th>
                <th>PIN</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_nacimiento']); ?></td>
                    <td><?php echo htmlspecialchars($row['ciudad']); ?></td>
                    <td><?php echo htmlspecialchars($row['calle']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['pin']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    // Liberar resultados y cerrar la conexión
    mysqli_free_result($result);
    mysqli_close($conexion);
    ?>

    <a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">
            arrow_left_alt
        </span></a> <br>

</body>
</html>
