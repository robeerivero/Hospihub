<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>HospiHub - Login de paciente</title>
    <!-- Metadatos del autor y diseñador del sitio -->
    <meta name="author" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <meta name="designer" content="David Conde Salado, Roberto Rivero Díaz, Jesús Javier Gallego Ibañez">
    <!-- Enlaces a las fuentes de Google y hojas de estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/procesar-diagnostico.css">
</head>
<body>
<header>   
    <nav>
        <div id="logo">HospiHub</div>
    </nav>
</header>

<?php
// Conectar a la base de datos MySQL usando mysqli
include('../conexion.php');
$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

session_start();

$medico_id = $_SESSION['medico_id'];
$email = $_SESSION['email'];

// Mostrar el nombre del médico
echo "<br><br><br><br><h2>$email, estas son tus Citas pendientes de finalizar</h2>";

// Consulta SQL para obtener las citas con estado 'Paciente Asignado' para el médico actual
$sql = "SELECT 
            c.Id_Cita, 
            c.Fecha, 
            DATE_FORMAT(c.Hora, '%H:%i:%s') AS Hora_Cita, 
            c.Id_Medico
        FROM 
            Tabla_Cita c
            JOIN Tabla_Medico m ON c.Id_medico = m.Id_medico
            JOIN Tabla_Departamento d ON m.Id_departamento = d.Id_departamento
            JOIN Tabla_Hospital h ON d.Id_hospital = h.Id_hospital
        WHERE
            c.Id_Medico = ?
            AND c.Estado = 'Paciente Asignado'";

// Preparar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $medico_id);

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Mostrar las citas en una tabla
echo "<table class='table table-striped'>\n";
echo "<thead>";
echo "<tr>";
echo "<th>Id de la cita</th>";
echo "<th>Fecha de la cita</th>";
echo "<th>Hora de la cita</th>";
echo "<th>Id del Medico</th>";
echo "<th>Insertar Diagnóstico</th>"; // Agregar una columna para el botón "Insertar Diagnóstico"
echo "</tr>";
echo "</thead>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . htmlentities($item, ENT_QUOTES) . "</td>\n";
    }
    // Agregar el botón "Añadir" en cada fila de la tabla
    echo "<td>";
    echo "<button type='button' onclick='mostrarFormulario(\"" . $row['Id_Cita'] . "\")'>Añadir</button>"; // Botón "Añadir"
    echo "</td>";
    echo "</tr>\n";
}
echo "</table>\n";

// Cerrar la consulta
$stmt->close();

// Cerrar la conexión
$conexion->close();
?>

<!-- Script para mostrar el formulario emergente -->
<script>
var numMedicamentos = 1; // Contador de medicamentos

function mostrarFormulario(idCita) {
    // Mostrar el formulario emergente
    var formulario = document.createElement("form");
    formulario.setAttribute("id", "formularioDiagnostico");
    formulario.innerHTML = `
    <h2>Insertar Diagnóstico</h2>
    <label for="descripcion">Descripción del diagnóstico:</label><br>
    <input type="text" id="descripcion" name="descripcion"><br><br>
    <label for="recomendacion">Recomendación:</label><br>
    <input type="text" id="recomendacion" name="recomendacion"><br><br>
    <div id="medicamentos"></div>
    <button type="button" onclick="agregarMedicamento()" id="botonMedicamento">Añadir Medicamento</button><br><br>
    <input type="hidden" name="cita_id" value="${idCita}">
    <button type="button" onclick="enviarFormulario()">Insertar Diagnóstico</button><br><br>
    <button type="button" onclick="window.location.href='../menu-medico.php'" id="volver">Volver al menú de médico <span class="material-symbols-outlined">home</span></button>
    `;
    document.body.appendChild(formulario);
}

// Función para agregar un medicamento
function agregarMedicamento() {
    var divMedicamentos = document.getElementById("medicamentos");
    var nuevoMedicamento = document.createElement("div");
    nuevoMedicamento.innerHTML = `
    <h3>Medicamento ${numMedicamentos}</h3>
    <label for="nombre_medicamento${numMedicamentos}">Nombre del Medicamento:</label><br>
    <input type="text" id="nombre_medicamento${numMedicamentos}" name="nombre_medicamento[]"><br><br>
    <label for="frecuencia${numMedicamentos}">Frecuencia del Medicamento:</label><br>
    <input type="text" id="frecuencia${numMedicamentos}" name="frecuencia[]"><br><br>
    `;
    divMedicamentos.appendChild(nuevoMedicamento);
    numMedicamentos++;
}

// Función para enviar el formulario
function enviarFormulario() {
    var formulario = document.getElementById("formularioDiagnostico");
    formulario.setAttribute("action", "insertar-diagnostico.php");
    formulario.setAttribute("method", "post");
    formulario.submit();
}
</script>

</body>
</html>
