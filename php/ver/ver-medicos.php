<?php
include('../conexion.php');
$conexion = conexion();

// Consulta SQL actualizada para obtener los médicos con dirección, departamento y hospital
$sql = "CALL Obtener_Medicos_Cursor()";

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
                <tr align="center">
                    <td><?php echo htmlspecialchars($row['Id_medico']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['Apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['Fecha_nacimiento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Ciudad']); ?></td>
                    <td><?php echo htmlspecialchars($row['Calle']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['PIN']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nombre_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Id_departamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nombre_hospital']); ?></td>
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
