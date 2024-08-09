<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaTecnologica;
use Illuminate\Http\Request;
use App\Models\Estado;
use Illuminate\Support\Facades\Log; // Asegúrate de importar la clase Log

class AsistenciasTecnologicassController extends Controller
{
    public function index()
    {
        $asistencias = AsistenciaTecnologica::with('estado')->get();
        $estados = Estado::all(); // Obtener todos los estados

        // Registrar en log la información obtenida
        Log::info('Listado de asistencias tecnológicas:', $asistencias->toArray());
        Log::info('Listado de estados:', $estados->toArray());

        return view('asistencias_tecnologicas', compact('asistencias', 'estados'));
    }

    public function store(Request $request)
    {
        // Registrar en log que la función se ha iniciado
        Log::info('Inicio del método store para crear una asistencia tecnológica.');

        // Validar los datos de entrada
        try {
            $validatedData = $request->validate([
                'tipo_requerimiento' => 'required|string|max:255',
                'solicitante' => 'required|string|max:255',
                'fecha_solicitud' => 'required|date',
                'tipo_bien' => 'required|string|max:255',
                'estado_id' => 'required|exists:estados,id',
            ]);

            // Registrar en log los datos validados
            Log::info('Datos validados para crear asistencia tecnológica:', $validatedData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Registrar los errores de validación en los logs
            Log::error('Errores de validación en el método store:', $e->errors());

            // Redirigir con errores a la vista anterior
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Crear una nueva asistencia tecnológica
        $asistencia = AsistenciaTecnologica::create($validatedData);

        // Registrar en log el éxito de la creación
        Log::info('Asistencia tecnológica creada con éxito:', $asistencia->toArray());

        // Redirigir a la vista con un mensaje de éxito
        return redirect()->route('asistencias_tecnologicas')->with('success', 'Asistencia tecnológica creada con éxito.');
    }
}
