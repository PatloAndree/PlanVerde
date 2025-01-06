<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a nuestra plataforma</title>
    <style>
        /* Estilos en línea para asegurar compatibilidad */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8; /* Color de fondo suave */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff; /* Color de fondo del contenedor */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #28a745; /* Color verde */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .body {
            padding: 20px;
        }
        .footer {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #218838; /* Color verde oscuro */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #1e7e34; /* Color verde más oscuro al pasar el cursor */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido, {{ $empresa->nombre }}!</h1>
        </div>
        <div class="body">
            <p>Nos complace informarte que tu empresa ha sido creada exitosamente.</p>
            <p>Tu rango de suscripción es desde <strong>{{ $fechaInicio }}</strong> hasta <strong>{{ $fechaFin }}</strong>.</p>
            <p>Tu correo de inicio de sesión es: <strong>{{ $usuario->email }}</strong></p> <!-- Correo del usuario -->
            <p>Tu contraseña de acceso es: <strong>{{ $password }}</strong></p>
            <p>Haz clic en el botón a continuación para acceder a tu cuenta:</p>
            <a href="{{ url('/') }}" class="btn" style="color: white">Ir a la plataforma</a>
        </div>
        <div class="footer">
            <p>¡Gracias por unirte a nosotros!</p>
            <p>&copy; {{ date('Y') }} Tu Empresa. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
