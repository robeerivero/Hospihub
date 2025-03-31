<?php
include('../conexion.php');
$conexion = conexion();

// Consulta SQL corregida para obtener los departamentos con la dirección del hospital
$sql = "CALL Obtener_Departamentos_Hospitales_Cursor()";

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
                <tr align="center">
                    <td><?php echo htmlspecialchars($row['Id_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nombre_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Ubicacion_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Id_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nombre_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['Ciudad_hospital']); ?></td>
                    <td><?php echo htmlspecialchars($row['Calle_hospital']); ?></td>
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