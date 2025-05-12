<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminando Citas...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        .progress-container {
            width: 50%;
            margin: auto;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 100%;
            height: 30px;
            background-color: #FF0000; /* Rojo semáforo */
            transition: width 0.5s ease-in-out;
        }

        .hidden {
            display: none;
        }

        .btn-back {
            display: block;
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

    <h1>⏳ Eliminando todas las citas...</h1>

    <div class="progress-container">
        <div id="progress-bar" class="progress-bar"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let progress = document.getElementById('progress-bar');

            let progreso = 100;
            let interval = setInterval(() => {
                progreso -= 10;
                progress.style.width = progreso + '%';

                if (progreso <= 0) {
                    clearInterval(interval);
                    window.location.href = '{{ route("admin.citas.eliminar") }}'; // Llama a la función de eliminación
                }
            }, 1000); // Cada segundo reduce el progreso
        });
    </script>

</body>
</html>
