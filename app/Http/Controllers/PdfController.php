<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nuevat;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class PdfController extends Controller
{
    public function generarpdfReporte(Request $request)
    {
        // Aumenta el límite de memoria según sea necesario
        ini_set('memory_limit', '512M');

        // Obtén el término de búsqueda desde DataTables
        $searchTerm = $request->input('search');

        // Consulta base de datos de bienes
        $query = Nuevat::query();

        // Aplica filtros si existe un término de búsqueda
        if (!empty($searchTerm)) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('codigo_bien', 'like', '%' . $searchTerm . '%')
                    ->orWhere('codigo_anterior', 'like', '%' . $searchTerm . '%')
                    ->orWhere('custodio_actual', 'like', '%' . $searchTerm . '%')
                    ->orWhere('bodega', 'like', '%' . $searchTerm . '%')
                    ->orWhere('custodio_activo', 'like', '%' . $searchTerm . '%');
            });
        }

        // Obtén los resultados paginados
        $bienes = $query->paginate(50); // Ajusta según el tamaño de página de tu DataTable

        // Genera el PDF y lo descarga
        $pdf = FacadePdf::loadView('pdf.bienes', compact('bienes'));
        return $pdf->download('bienes.pdf');
    }
}
