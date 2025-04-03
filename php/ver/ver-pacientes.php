<?php
include('../conexion.php');
$conexion = conexion();

// Llamar al procedimiento almacenado para obtener los pacientes
$sql = "CALL Obtener_Pacientes_Cursor(NULL)";
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
    <style>
        /* Estilo específico para la columna de acciones */
        th:last-child,
        td:last-child {
            width: 1%;
            white-space: nowrap;
            padding: 6px;
        }
        
        /* Estilo para el botón-editar */
        .btn-accion {
            display: inline-block;
            padding: 4px 8px;
            font-size: 14px;
            background: #58ec54;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background 0.3s;
            margin: 2px;
        }
        
        .btn-accion:hover {
            background: #45c042;
        }
    </style>
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
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr align="center">
                    <td><?php echo htmlspecialchars($row['Id_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['Apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['Fecha_nacimiento']); ?></td>
                    <td><?php echo htmlspecialchars($row['Ciudad']); ?></td>
                    <td><?php echo htmlspecialchars($row['Calle']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['PIN']); ?></td>
                    <td><a href="../editar/editar-paciente.php?id=<?= $row['Id_paciente'] ?>" class="btn-accion">Editar</a></td>
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
