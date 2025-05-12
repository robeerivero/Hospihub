<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas eliminadas correctamente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f7f9fc;
        }

        .message-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            display: inline-block;
            margin-top: 50px;
        }

        h1 {
            font-size: 2rem;
            color: #dc3545; /* Rojo de eliminación */
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 15px 20px;
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="message-container">
        <h1>🗑️ ¡Todas las citas han sido eliminadas!</h1>
        <a href="{{ route('menu_admin') }}" class="btn-back">🏠 Volver al Menú</a>
    </div>

</body>
</html>
