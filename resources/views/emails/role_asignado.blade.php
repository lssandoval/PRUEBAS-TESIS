<!DOCTYPE html>
<html>

<head>
    <title>Asignación de Perfil</title>
</head>

<body>
    <p>Estimad@ {{ $userName }},</p>
    <p>El Sistema de Gestión de Bienes Tecnológicos te da la bienvenida.</p>
    <p>Tus perfiles asignados al sistema son:</p>
    <ul>
        @foreach ($roles as $role)
            @if ($role == 1)
                <li>Administrador UTIC</li>
            @elseif ($role == 2)
                <li>Administrador Tecnológico</li>
            @elseif ($role == 3)
                <li>Visualizador</li>
            @else
                <li>Rol Desconocido</li>
            @endif
        @endforeach
    </ul>
    <p>Fecha de creación del perfil: {{ $date }}</p>
</body>

</html>
