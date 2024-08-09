<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nuevat;
use App\Models\NuevaC;
use Illuminate\Support\Facades\Log;

class BienesController extends Controller
{
    public $id;
    public $codigo_bien;

    public function variables($id, $codigo_bien)
    {
        $this->id = $id;
        $this->codigo_bien = $codigo_bien;
    }

    public function index(Request $request)
    {
        return view('tabla_bienes');
    }

    public function bienes()
    {
        $bienes = Nuevat::all();
        return datatables()->of($bienes)->toJson();
    }

    public function eliminar(Request $request)
    {
        // Logs para mostrar la información recibida
        Log::info('Solicitud recibida para eliminar bien.', [
            'codigo_bien' => $request->codigo_bien,
        ]);

        // Validación básica, asegúrate de implementar la lógica adecuada de validación según tu caso
        $request->validate([
            'codigo_bien' => 'required|exists:nuevat,codigo_bien',
        ]);

        // Logs para mostrar que la validación ha pasado correctamente
        Log::info('Validación pasada para eliminar bien.');

        // Eliminar el bien
        Nuevat::where('codigo_bien', $request->codigo_bien)->delete();

        // Logs para mostrar que el bien ha sido eliminado correctamente
        Log::info('Bien eliminado correctamente.', [
            'codigo_bien' => $request->codigo_bien,
        ]);

        return response()->json(['success' => true, 'message' => 'Bien eliminado correctamente.']);
    }

    public function editarBien($id)
    {
        $bien = Nuevat::find($id);
        if (!$bien) {
            return redirect()->route('bienes')->with('error', 'Bien no encontrado.');
        }

        $nuevaCs = NuevaC::where('codigo_bien', $bien->codigo_bien)->get();

        return view('editar_bien', compact('bien', 'nuevaCs'));
    }

    public function actualizarBien(Request $request, $id)
    {
        $request->validate([
            'codigo_bien' => 'required|string|max:255',
            'en_uso' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'custodio_identificado' => 'nullable|string|max:255',
            'fecha_ingreso' => 'nullable|string|max:255',
            'periodo_garantia' => 'nullable|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'fecha_ultimo_mantenimiento' => 'nullable|string|max:255',
            'recomendacion_1' => 'nullable|string|max:255',
            'recomendacion_2' => 'nullable|string|max:255',
            'cedula_esbye' => 'nullable|string|max:255',
            'custodio_esbye' => 'nullable|string|max:255',
            'serial_esbye' => 'nullable|string|max:255',
            'modelo_esbye' => 'nullable|string|max:255',
            'descripcion_esbye' => 'nullable|string|max:255',
            'componentes.*.codigo_bien_compuesto' => 'nullable|string|max:255',
            'componentes.*.tipoC' => 'nullable|string|max:255',
            'componentes.*.descripcionC' => 'nullable|string|max:255',
        ]);

        $bien = Nuevat::find($id);
        if (!$bien) {
            return redirect()->route('bienes')->with('error', 'Bien no encontrado.');
        }

        $bien->fill($request->all());
        $bien->save();

        // Actualizar los campos del modelo NuevaC
        if ($request->has('componentes')) {
            foreach ($request->componentes as $componenteData) {
                if (isset($componenteData['id'])) {
                    $nuevaC = NuevaC::find($componenteData['id']);
                    if ($nuevaC) {
                        $nuevaC->fill($componenteData);
                        $nuevaC->save();
                    }
                } else {
                    // Si no hay ID, se asume que es un nuevo componente
                    NuevaC::create($componenteData);
                }
            }
        }

        return redirect()->route('bienes')->with('success', 'Bien actualizado correctamente.');
    }
}
