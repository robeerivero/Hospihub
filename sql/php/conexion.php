<?php
function conexion() {
    // Configuración de la conexión
    $servidor = '127.0.0.1'; // Servidor de la base de datos (localhost)
    $usuario = 'root'; // Usuario de la base de datos
    $contrasenna = 'password'; // Contraseña del usuario (vacía si no tiene contraseña)
    $baseDeDatos = 'hospihub'; // Nombre de la base de datos que has creado

    // Crear la conexión
    $conn = mysqli_connect($servidor, $usuario, $contrasenna, $baseDeDatos);

    // Verificar la conexión
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Para verificar que la conexión está activa, podrías hacer una consulta simple:
    $consulta = "SELECT DATABASE()"; // Verifica la base de datos actual
    $resultado = mysqli_query($conn, $consulta);

    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }

    return $conn;
}
?>
