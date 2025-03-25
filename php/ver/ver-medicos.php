<?php
include('../conexion.php');
$conexion = conexion();

// Consulta SQL actualizada para obtener los médicos con dirección, departamento y hospital
$sql = "SELECT m.id_medico, m.nombre AS nombre_medico, m.apellidos, m.telefono, m.fecha_nacimiento, dir.ciudad, dir.calle, m.email, m.pin, d.nombre AS nombre_departamento, d.id_departamento, h.nombre AS nombre_hospital 
        FROM medico m
        LEFT JOIN direccion dir ON m.id_direccion = dir.id_direccion
        LEFT JOIN departamento d ON m.id_departamento = d.id_departamento
        LEFT JOIN hospital h ON d.id_hospital = h.id_hospital";

$result = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiHub - Lista de médicos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/ver.css" type="text/css">
</head>
<body>

    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <br><br><br><br>
    
    <h1>Lista de Médicos del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Médico</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Fecha de Nacimiento</th>
                <th>Ciudad</th>
                <th>Calle</th>
                <th>Email</th>
                <th>PIN</th>
                <th>Nombre Departamento</th>
                <th>Id Departamento</th>
                <th>Nombre del Hospital</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id_medico']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_medico']); ?></td>
                    <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_nacimiento']); ?></td>
                    <td><?php echo htmlspecialchars($row['ciudad']); ?></td>
                    <td><?php echo htmlspecialchars($row['calle']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['pin']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['id_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_hospital']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    mysqli_free_result($result);
    mysqli_close($conexion);
    ?>

    <a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">
            arrow_left_alt
        </span></a> <br>

</body>
</html>
