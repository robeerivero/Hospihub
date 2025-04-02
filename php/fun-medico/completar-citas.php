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

    <meta name="author" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <meta name="designer" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">

    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/procesar-diagnostico.css">
</head>
<body>

<header>
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<h2><?php echo htmlspecialchars($email); ?>, estas son tus citas pendientes de finalizar</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Id de la cita</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Id del Médico</th>
            <th>Insertar Diagnóstico</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT Id_Cita, Fecha, DATE_FORMAT(Hora, '%H:%i:%s') AS Hora_Cita, Id_Medico 
                FROM Cita 
                WHERE Id_Medico = ? AND Estado = 'Paciente Asignado'";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $medico_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Id_Cita']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Hora_Cita']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Id_Medico']) . "</td>";
            echo "<td><button type='button' onclick='mostrarFormulario(" . $row['Id_Cita'] . ")'>Añadir</button></td>";
            echo "</tr>";
        }

        $stmt->close();
        $conexion->close();
        ?>
    </tbody>
</table>

<button type="button" onclick="window.location.href='../menu-medico.php'" id="volver">
    Volver al menú de médico <span class="material-symbols-outlined">home</span>
</button>

<script>
var numMedicamentos = 1;

function mostrarFormulario(idCita) {
    var formulario = document.createElement("form");
    formulario.setAttribute("id", "formularioDiagnostico");
    formulario.setAttribute("action", "insertar-diagnostico.php");
    formulario.setAttribute("method", "post");

    formulario.innerHTML = `
        <h2>Insertar Diagnóstico</h2>
        <label for="descripcion">Descripción:</label><br>
        <input type="text" id="descripcion" name="descripcion" required><br><br>

        <label for="recomendacion">Recomendación:</label><br>
        <input type="text" id="recomendacion" name="recomendacion" required><br><br>

        <div id="medicamentos"></div>
        <button type="button" onclick="agregarMedicamento()">Añadir Medicamento</button><br><br>

        <input type="hidden" name="cita_id" value="${idCita}">
        <button type="submit">Insertar Diagnóstico</button>
    `;

    document.body.appendChild(formulario);
}

function agregarMedicamento() {
    var divMedicamentos = document.getElementById("medicamentos");
    var nuevoMedicamento = document.createElement("div");
    nuevoMedicamento.innerHTML = `
        <h3>Medicamento ${numMedicamentos}</h3>
        <label>Nombre:</label><br>
        <input type="text" name="nombre_medicamento[]" required><br><br>

        <label>Frecuencia:</label><br>
        <input type="text" name="frecuencia[]" required><br><br>
    `;
    divMedicamentos.appendChild(nuevoMedicamento);
    numMedicamentos++;
}
</script>

</body>
</html>
