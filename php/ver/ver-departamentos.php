<?php
include('../conexion.php');
$conexion = conexion();

// Consulta SQL corregida para obtener los departamentos con la dirección del hospital
$sql = "SELECT d.id_departamento, d.nombre AS nombre_departamento, d.ubicacion, 
               h.id_hospital, h.nombre AS nombre_hospital, 
               dir.ciudad AS ciudad_hospital, dir.calle AS calle_hospital
        FROM departamento d
        JOIN hospital h ON d.id_hospital = h.id_hospital
        JOIN direccion dir ON h.id_direccion = dir.id_direccion";

$result = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiHub - Lista de departamentos</title>
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

    <h1>Lista de Departamentos del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Departamento</th>
                <th>Nombre Departamento</th>
                <th>Ubicación Departamento</th>
                <th>Id Hospital</th>
                <th>Nombre Hospital</th>
                <th>Ciudad Hospital</th>
                <th>Calle Hospital</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['ubicacion']); ?></td>
                    <td><?php echo htmlspecialchars($row['id_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['ciudad_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['calle_hospital']); ?></td>
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