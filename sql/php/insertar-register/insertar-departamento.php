<?php
    // Conexión a la base de datos MySQL
    include('../conexion.php');
    $conexion = conexion();

    // Inicializar mensaje vacío
    $mensaje = "";

    // Verificar si hay un mensaje en la URL
    if (isset($_GET['mensaje'])) {
        if ($_GET['mensaje'] == "ok") {
            $mensaje = "<p style='color: green; text-align: center;'>Departamento registrado correctamente.</p>";
        } elseif ($_GET['mensaje'] == "error") {
            $mensaje = "<p style='color: red; text-align: center;'>" . htmlspecialchars($_GET['detalle']) . "</p>";
        }
    }

    // Comprobar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar datos del formulario
        $nombre_hospital = $_POST["nombre_hospital"];
        $nombre_departamento = $_POST["nombre_departamento"];
        $ubicacion = $_POST["ubicacion"];

        // Activar excepciones en MySQLi
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            // Preparar la llamada al procedimiento almacenado
            $sql = "CALL Insertar_Departamento(?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta.");
            }

            // Vincular los parámetros
            mysqli_stmt_bind_param($stmt, "sss", $nombre_hospital, $nombre_departamento, $ubicacion);

            // Ejecutar la sentencia
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Redirigir con mensaje de éxito
            header("Location: " . $_SERVER['PHP_SELF'] . "?mensaje=ok");
            exit();

        } catch (mysqli_sql_exception $e) {
            // Capturar errores de SQL
            $errorMsg = urlencode($e->getMessage());
            header("Location: " . $_SERVER['PHP_SELF'] . "?mensaje=error&detalle=$errorMsg");
            exit();
        } catch (Exception $e) {
            // Capturar otros errores
            $errorMsg = urlencode($e->getMessage());
            header("Location: " . $_SERVER['PHP_SELF'] . "?mensaje=error&detalle=$errorMsg");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
<script src="//cdn.conveythis.com/javascript/conveythis.js?api_key=pub_450bff64f17d3b1a1a1efac21fe1cfa8"></script>

    <title>HospiHub - Insertar Departamento</title>  
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Roberto Rivero Díaz, Jesus Gallego Ibañez, David Conde Salado">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <header>   
        <nav>
            <div id="logo">HospiHub</div>
        </nav>
    </header>

    <div id="contenedor">
        <h1><?php echo $mensaje; ?>Registrar Departamento<span class="material-symbols-outlined">business</span></h1>
    
        <form action="" method="post" id="formulario">
            <label for="nombre_hospital">Nombre del hospital</label><br>
            <input type="text" id="nombre_hospital" name="nombre_hospital" required>
            <br><br>
            <label for="nombre_departamento">Nombre del departamento</label><br>
            <input type="text" id="nombre_departamento" name="nombre_departamento" required>
            <br><br>
            <label for="ubicacion">Ubicación</label><br>
            <input type="text" id="ubicacion" name="ubicacion" required>
            <br><br>
            <button type="submit">Registrar</button>
        </form>
        <br><br>
    </div>
    
    <a href="../menu-admin.php">Regresar al menú del administrador <span class="material-symbols-outlined">arrow_left_alt</span></a> <br>
    <br>
    <a href=".." id="volver">Volver al inicio <span class="material-symbols-outlined">home</span></a>
</body>
</html>