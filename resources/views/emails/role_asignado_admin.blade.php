<!-- resources/views/emails/role_asignado.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SGBT - Asignación Perfil</title>
</head>

<body>
    <p>Estimados administradores,</p>
    <p>Se les informa que se ha realizado una asignación de perfil al usuario: {{ $userName }}</p>
    <p>al cual se le ha asignado los siguientes roles: </p>
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
    <p>Fecha: {{ $date }}</p>
</body>

</html>