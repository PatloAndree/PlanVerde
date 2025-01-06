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
            background: linear-gradient(90deg, #E91E63, #950033);
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
        <h3>DEUDA PENDIENTE</h3>
        <h2>{{ $empresa->nombre }}</h2>
    </div>

    <h4 class="text-success fw-bold ms-4 mt-4">Estimado usuario se le recuerda que tiene una deuda pendiente. Por favor
        regularizarla </h4>
    <div class="container activity-list">

    </div>
    <h5 class="text-success fw-bold ms-4 mt-4">Gerencia Plan verde | gerencia@planverde.com </h5>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
