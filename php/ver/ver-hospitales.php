<?php
include('../conexion.php');
$conexion = conexion();

// Consulta SQL para obtener los hospitales
$sql = "SELECT h.id_hospital, h.nombre, dir.ciudad, dir.calle
 FROM hospital h
 JOIN direccion dir ON h.id_direccion = dir.id_direccion";

$result = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiHub - Lista de hospitales</title>
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

    <h1>Lista de Hospitales del Sistema</h1>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Id del Hospital</th>
                <th>Nombre del Hospital</th>
                <th>Ciudad del Hospital</th>
                <th>Calle del Hospital</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['ciudad']); ?></td>
                    <td><?php echo htmlspecialchars($row['calle']); ?></td>
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
