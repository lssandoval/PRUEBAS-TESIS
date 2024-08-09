<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Bienes Actuales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0; /* Gray light background */
            color: #333; /* Dark gray text */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5; /* Gray background */
        }
        tr:nth-child(odd) {
            background-color: #ffffff; /* White background */
        }
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e0e0e0; /* Light gray */
            color: #333; /* Dark gray text */
            border: 1px solid #ddd;
            text-align: center;
        }
        .detalle {
            padding: 10px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Reporte Técnico Bienes Tecnológicos</h1>
    <div class="info">
        <span>Fecha de creación:</span> {{ now()->format('d/m/Y') }}<br>
        <span>Creador:</span> {{ Auth::user()->name }} <!-- Ajustar según cómo obtienes el nombre del usuario logueado -->
    </div>
    @foreach($bienes as $bien)
        <div class="detalle">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Detalles del Bien</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID:</td>
                        <td>{{ $bien->id }}</td>
                    </tr>
                    <tr>
                        <td>Código Bien:</td>
                        <td>{{ $bien->codigo_bien }}</td>
                    </tr>
                    <tr>
                        <td>En Uso:</td>
                        <td>{{ $bien->en_uso }}</td>
                    </tr>
                    <tr>
                        <td>Tipo:</td>
                        <td>{{ $bien->tipo }}</td>
                    </tr>
                    <tr>
                        <td>Marca:</td>
                        <td>{{ $bien->marca }}</td>
                    </tr>
                    <tr>
                        <td>Modelo:</td>
                        <td>{{ $bien->modelo }}</td>
                    </tr>
                    <tr>
                        <td>Serial:</td>
                        <td>{{ $bien->serial }}</td>
                    </tr>
                    <tr>
                        <td>Ubicación:</td>
                        <td>{{ $bien->ubicacion }}</td>
                    </tr>
                    <tr>
                        <td>Custodio Identificado:</td>
                        <td>{{ $bien->custodio_identificado }}</td>
                    </tr>
                    <tr>
                        <td>Fecha de Ingreso:</td>
                        <td>{{ $bien->fecha_ingreso }}</td>
                    </tr>
                    <tr>
                        <td>Periodo de Garantía:</td>
                        <td>{{ $bien->periodo_garantia }}</td>
                    </tr>
                    <tr>
                        <td>Proveedor:</td>
                        <td>{{ $bien->proveedor }}</td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td>{{ $bien->estado }}</td>
                    </tr>
                    <tr>
                        <td>Fecha Último Mantenimiento:</td>
                        <td>{{ $bien->fecha_ultimo_mantenimiento }}</td>
                    </tr>
                    <tr>
                        <td>Recomendación 1:</td>
                        <td>{{ $bien->recomendacion_1 }}</td>
                    </tr>
                    <tr>
                        <td>Recomendación 2:</td>
                        <td>{{ $bien->recomendacion_2 }}</td>
                    </tr>
                    <tr>
                        <td>Cédula ESBYE:</td>
                        <td>{{ $bien->cedula_esbye }}</td>
                    </tr>
                    <tr>
                        <td>Custodio ESBYE:</td>
                        <td>{{ $bien->custodio_esbye }}</td>
                    </tr>
                    <tr>
                        <td>Serial ESBYE:</td>
                        <td>{{ $bien->serial_esbye }}</td>
                    </tr>
                    <tr>
                        <td>Modelo ESBYE:</td>
                        <td>{{ $bien->modelo_esbye }}</td>
                    </tr>
                    <tr>
                        <td>Descripción ESBYE:</td>
                        <td>{{ $bien->descripcion_esbye }}</td>
                    </tr>
                    <tr>
                        <td>Fecha Creación:</td>
                        <td>{{ $bien->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Fecha Actualización:</td>
                        <td>{{ $bien->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
</body>
</html>
