<!-- resources/views/persona/index.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Personas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>per_id</th>
                    <th>nombre_completo</th>
                    <th>área(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personas as $persona)
                <tr>
                    <td>{{ $persona->per_id }}</td>
                    <td>{{ $persona->nombre_completo }}</td>
                    <td>
                        @foreach($persona->areas as $area)
                            {{ $area->are_nombre }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
