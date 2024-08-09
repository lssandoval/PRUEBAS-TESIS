<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class GenerarListaQRController extends Controller
{
    public function index()
    {
        // Obtener todas las transacciones de la base de datos
        $transacciones = Transaccion::all();
        // Pasar las transacciones a la vista
        return view('tabla_bienes', compact('transacciones'));
    }

    public function generateQRCodes(Request $request)
    {
        // Obtener todas las transacciones de la base de datos
        $transacciones = Transaccion::all();

        foreach ($transacciones as $transaccion) {
            $data = [
                'id' => $transaccion->id,
                'codigo_bien' => $transaccion->codigo_bien,
            ];

            // Concatenar los datos en una cadena para el contenido del código QR
            $contenidoQR = "ID: {$data['id']}, Código Bien: {$data['codigo_bien']}";

            // Instanciar el renderizador de imagen con Imagick
            $renderer = new ImageRenderer(
                new RendererStyle(150), // Reducir el tamaño a 300
                new ImagickImageBackEnd()
            );

            // Instanciar el escritor
            $writer = new Writer($renderer);

            try {
                // Generar el código QR en memoria
                $qrCodeData = $writer->writeString($contenidoQR);

                // Generar un nombre único para el archivo JPEG
                $fileName = 'qr_code_' . $data['codigo_bien'] . '.png';

                // Guardar el código QR en el almacenamiento de Laravel
                Storage::disk('public')->put('Qrcodes/' . $fileName, $qrCodeData);

                // Log de éxito
                Log::info("Código QR generado exitosamente para ID: {$data['id']}, Código Bien: {$data['codigo_bien']}");
            } catch (\Exception $e) {
                // Log del error detallado
                Log::error("Error al generar el código QR: {$e->getMessage()}");
            }
        }

        // Redirigir de vuelta a la página desde la que se hizo la solicitud
        return Redirect::back()->with('success', 'Códigos QR generados correctamente para todos los bienes.');
    }

    public function generatePDF()
    {
        // Obtener todas las transacciones de la base de datos
        $transacciones = Transaccion::all();

        // Configuración de dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        // Preparar el HTML para el PDF
        $html = '<html><head><style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            .page { page-break-after: always; }
            .container { width: 100%; margin: 0 auto; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            th { background-color: #f2f2f2; }
            .qr-code { width: 80px; height: 80px; } // Ajusta el tamaño aquí
        </style></head><body>';

        $pageSize = 10; // Número de filas por página
        $totalRows = count($transacciones);
        $totalPages = ceil($totalRows / $pageSize);
        $currentRow = 0;

        for ($page = 1; $page <= $totalPages; $page++) {
            $html .= '<div class="page">';
            $html .= '<div class="container">';
            $html .= '<table>';
            $html .= '<thead><tr><th>ID</th><th>Código Bien</th><th>Código QR</th></tr></thead>';
            $html .= '<tbody>';

            for ($row = $currentRow; $row < $currentRow + $pageSize && $row < $totalRows; $row++) {
                $transaccion = $transacciones[$row];
                $fileName = 'qr_code_' . $transaccion->codigo_bien . '.png';
                $qrCodeUrl = url('storage/Qrcodes/' . $fileName); // Genera una URL pública

                $html .= '<tr>';
                $html .= '<td>' . $transaccion->id . '</td>';
                $html .= '<td>' . $transaccion->codigo_bien . '</td>';
                $html .= '<td>';
                if (Storage::disk('public')->exists('Qrcodes/' . $fileName)) {
                    $html .= '<img src="' . $qrCodeUrl . '" class="qr-code" />';
                } else {
                    $html .= 'QR no encontrado';
                }
                $html .= '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';

            $currentRow += $pageSize;
        }

        $html .= '</body></html>';

        // Cargar el HTML y generar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Descargar el archivo PDF
        return $dompdf->stream('lista_codigos_qr.pdf', ['Attachment' => true]);
    }
}
