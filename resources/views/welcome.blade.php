<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SGBCOSEDE</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Verdana:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Verdana', sans-serif; /* Cambiado a Verdana */
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #f0f0f0;
            flex-direction: column;
        }

        .left-section {
            width: 50%;
            background: url('/images/fondo.jpg') no-repeat center center;
            background-size: cover;
            display: none; /* Oculto por defecto para dispositivos pequeños */
        }

        .right-section {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            background-color: white; /* Cambiado a blanco */
            color: #333; /* Color de texto cambiado a oscuro para contraste */
            padding: 30px;
            box-sizing: border-box;
        }

        .right-section .content {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 4cm; /* Ajuste para centrar verticalmente */
            box-sizing: border-box;
        }

        .title {
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: justify;
            text-transform: uppercase; /* Texto en mayúsculas */
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%; /* Aseguramos que los botones ocupen todo el ancho */
        }

        .nav-links a {
            display: block;
            margin: 10px 0;
            padding: 15px 0; /* Cambiado para abarcar todo el ancho */
            border: 2px solid transparent;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s, border-color 0.3s, transform 0.3s;
            font-size: 1.1em;
            font-weight: bold;
            width: 100%; /* Aseguramos que los botones ocupen todo el ancho */
            text-align: center; /* Centrar el texto dentro del botón */
            
        }

        .nav-links a:nth-child(1) {
            background-color: #FFD700; /* Amarillo */
            color: #333;
        }

        .nav-links a:nth-child(1):hover {
            background-color: #FFC107; /* Amarillo más oscuro */
        }

        .nav-links a:nth-child(2) {
            background-color: #007BFF; /* Azul */
        }

        .nav-links a:nth-child(2):hover {
            background-color: #0056b3; /* Azul más oscuro */
        }

        .nav-links a:nth-child(3) {
            background-color: #DC3545; /* Rojo */
        }

        .nav-links a:nth-child(3):hover {
            background-color: #C82333; /* Rojo más oscuro */
        }

        .footer {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #555;
            padding-top: 20px;
            margin-top: 20px;
        }

        .footer .left-column img {
            max-width: 150px;
        }

        .footer .right-column {
            max-width: 400px;
            text-align: right;
        }

        @media (min-width: 768px) {
            body {
                flex-direction: row;
            }

            .left-section {
                display: block; /* Mostrar la imagen para pantallas más grandes */
            }

            .right-section {
                width: 50%;
                padding-top: 0;
            }

            .right-section .content {
                padding-top: 0; /* Quitar padding adicional para pantallas más grandes */
            }
        }
    </style>
</head>

<body>
    <div class="left-section"></div>
    <div class="right-section">
        <div class="content">
            <div class="title">
                Bienvenido Al Sistema de Gestión de Bienes COSEDE
            </div>
            @if (Route::has('login'))
            <div class="nav-links">
                @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">Registrar</a>
                @endif
                @endauth
            </div>
            @endif
        </div>
        <div class="footer">
            <div class="left-column">
                <img src="/images/logo_presidencia.png" alt="Logo Presidencia">
            </div>
            <div class="right-column">
                Av.Amazonas entre Unión Nacional de Periodistas y Alfonso Pereira,<br>
                Bloque Morado (Bloque 4) piso 9.<br>
                Plataforma Gubernamental de Gestión Financiera - Bloque 4 <br>
                Teléfono: (+593) 2 396 0340
            </div>
        </div>
    </div>
</body>

</html>
