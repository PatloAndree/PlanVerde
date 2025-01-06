<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades Próximas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .header {
            background: linear-gradient(90deg, #6c9008, #9cda02);
            color: rgb(255, 255, 255);
            font-weight: 700;
            padding: 20px;
            text-align: center;
        }

        .activity-list {
            margin: 20px;
        }

        .activity-item {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .activity-item:hover {
            transform: scale(1.02);
        }

        .activity-title {
            font-size: 1.2em;
            font-weight: bold;
        }

        .activity-date,
        .activity-type {
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>RECORDATORIO SEMANAL</h2>
    </div>

    <h4 class="text-success fw-bold ms-4 mt-4">Hola, Recuerda que es importante estar atento a todas nuestras
        actividades. </h4>
    <div class="container activity-list">
        @foreach ($actividades as $actividad)
            <div class="activity-item">
                <div class="activity-title">
                    {{ $actividad->titulo }}
                </div>
                <div class="activity-date">
                    Fecha de actividad: {{ $actividad->fecha_inicio }}
                </div>
                <div class="activity-type">
                    Tipo de actividad:
                    {{ $actividad->tipo == 1 ? 'Capacitación' : 'Mantenimiento' }}
                </div>
            </div>
            @endforeach
        </div>
        <h5 class="text-success fw-bold ms-4 mt-4">RR.HH  Plan verde | recursoshumanos@planverde.com </h5>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
