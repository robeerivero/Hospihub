<?php
session_start();
include('../conexion.php');
$conexion = conexion();

// Verificar si el médico ha iniciado sesión
if (!isset($_SESSION['medico_id'])) {
    header("Location: ../login/login-medico.php");
    exit();
}

$medico_id = $_SESSION['medico_id'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HospiHub - Citas Pendientes</title>
    
    <!-- Metadatos -->
    <meta name="author" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">
    <meta name="designer" content="Jesús Javier Gallego Ibañez, Roberto Rivero Díaz, David Conde Salado">

    <!-- Fuentes y estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/ver.css">
    <style>
        .btn-asignar {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-asignar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <nav>
        <div id="logo">HospiHub</div>
    </nav>

    <div id="contenedor">
        <h1>Citas Pendientes</h1>
        <h2>Médico: <?php echo htmlspecialchars($email); ?></h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Cita</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener citas pendientes del médico
                $sql = "SELECT 
                            c.Id_Cita, 
                            c.Fecha, 
                            DATE_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita,
                            c.Estado
                        FROM 
                            Cita c
                        WHERE 
                            c.Id_Medico = ? 

                        ORDER BY 
                            c.Fecha, c.Hora";
                
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $medico_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Id_Cita']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Hora_Cita']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Estado']) . "</td>";
                        
                        // Botón de acción según el estado
                        if ($row['Estado'] == 'Paciente Asignado') {
                            echo '<td><button class="btn-asignar" onclick="location.href=\'procesar-diagnostico.php?cita_id=' . $row['Id_Cita'] . '\'">Procesar Diagnóstico</button></td>';
                        } else {
                            echo '<td><button class="btn-asignar" onclick="location.href=\'ver-diagnostico.php?cita_id=' . $row['Id_Cita'] . '\'">Ver Diagnóstico</button></td>';
                        }
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay citas pendientes</td></tr>";
                }
                
                $stmt->close();
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <a href="../menu-medico.php" id="volver">
        Volver al menú de médico <span class="material-symbols-outlined">home</span>
    </a>

</body>
</html>