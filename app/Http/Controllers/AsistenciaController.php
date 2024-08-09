<?php
namespace App\Http\Controllers;

use App\Models\AsistenciaTecnologica;
use App\Models\Estado; // Asegúrate de importar el modelo Estado
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        // Obtener todas las asistencias y estados
        $asistencias = AsistenciaTecnologica::all();
        $estados = Estado::all(); // Obtener todos los estados
        
        return view('asistencias_tecnologicas', compact('asistencias', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_requerimiento' => 'required|string|max:255',
            'solicitante' => 'required|string|max:255',
            'fecha_solicitud' => 'required|date',
            'tipo_bien' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);

        AsistenciaTecnologica::create($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia creada exitosamente.');
    }
}