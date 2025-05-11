<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>COVID-19 en España</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 2rem;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 2rem;
        }

        .card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
            padding: 2rem;
        }

        ul {
            list-style: none;
            padding: 0;
            font-size: 1.1rem;
        }

        li {
            margin: 0.5rem 0;
        }

        strong {
            color: #2a7ae2;
        }

        a {
            display: block;
            margin-top: 2rem;
            text-align: center;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>COVID-19 en España</h1>

    <div class="card">
        <ul>
            <li><strong>Casos totales:</strong> {{ number_format($datos['cases']) }}</li>
            <li><strong>Casos hoy:</strong> {{ number_format($datos['todayCases']) }}</li>
            <li><strong>Fallecidos:</strong> {{ number_format($datos['deaths']) }}</li>
            <li><strong>Fallecidos hoy:</strong> {{ number_format($datos['todayDeaths']) }}</li>
            <li><strong>Recuperados:</strong> {{ number_format($datos['recovered']) }}</li>
            <li><strong>Críticos:</strong> {{ number_format($datos['critical']) }}</li>
        </ul>
    </div>

    <a href="javascript:window.history.back()" class="btn-back">← Volver al menú</a>

</body>
</html>
