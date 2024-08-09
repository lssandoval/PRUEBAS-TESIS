<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Settings;
use App\Models\Transaccion;
use App\Models\TransaccionComponentes;
use App\Models\ArchivoHistorial;
use App\Models\Persona;

class ArchivoController extends Controller
{
    public function __construct()
    {
        // Configurar PhpSpreadsheet para usar menos memoria
        Settings::setLibXmlLoaderOptions(LIBXML_PARSEHUGE);
    }

    public function subirArchivo(Request $request)
    {
        if ($request->hasFile('archivo')) {
            $request->validate([
                'archivo' => 'required|mimes:xlsx,xls|max:20480',
            ]);

            $archivo = $request->file('archivo');
            $archivo->move(public_path('Excels'), $archivo->getClientOriginalName());
            $filePath = public_path('Excels') . '/' . $archivo->getClientOriginalName();

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $chunkSize = 1000; // Tamaño del fragmento
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            for ($startRow = 2; $startRow <= $highestRow; $startRow += $chunkSize) { // Comenzar desde la fila 2
                $endRow = min($startRow + $chunkSize - 1, $highestRow);

                for ($row = $startRow; $row <= $endRow; $row++) {
                    $data = [];
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $cellValue = $worksheet->getCell($col . $row)->getValue();
                        $data[] = $cellValue;
                    }

                    if (!empty($data[0]) && count($data) >= 20) {
                        // Buscar el estado del funcionario basado en la cedula_esbye
                        $persona = Persona::where('per_cedula', $data[15])->first();

                        if ($persona) {
                            // Obtener el estado del usuario desde el modelo Usuario relacionado
                            $estado = null;
                            if ($persona->usuario) {
                                $estado = $persona->usuario->est_id;
                            }

                            if ($estado == 1) { // HABILITADO
                                // Crear una nueva transacción y guardar la información
                                $transaccion = new Transaccion();
                                $transaccion->codigo_bien = $data[0];
                                $transaccion->en_uso = $data[1];
                                $transaccion->tipo = $data[2];
                                $transaccion->marca = $data[3];
                                $transaccion->modelo = $data[4];
                                $transaccion->serial = $data[5];
                                $transaccion->ubicacion = $data[6];
                                $transaccion->custodio_identificado = $data[7];
                                $transaccion->fecha_ingreso = $data[8];
                                $transaccion->periodo_garantia = $data[9];
                                $transaccion->proveedor = $data[10];
                                $transaccion->estado = $data[11];
                                $transaccion->fecha_ultimo_mantenimiento = $data[12];
                                $transaccion->recomendacion_1 = $data[13];
                                $transaccion->recomendacion_2 = $data[14];
                                $transaccion->cedula_esbye = $data[15];
                                $transaccion->custodio_esbye = $data[16];
                                $transaccion->serial_esbye = $data[17];
                                $transaccion->modelo_esbye = $data[18];
                                $transaccion->descripcion_esbye = $data[19];
                                $transaccion->save();
                            } else {
                                // Puedes registrar o manejar el caso en el que el usuario está INHABILITADO si es necesario
                            }
                        }
                    }
                }
            }

            ArchivoHistorial::create([
                'usuario' => Auth::user()->name,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'fecha_subida' => now(),
            ]);

            return Redirect::back()->with('success', 'Archivo subido correctamente');
        }

        return Redirect::back()->with('error', 'No se ha enviado ningún archivo');
    }

    // El método subirArchivoComponentes se puede ajustar de manera similar si es necesario



    public function subirArchivoComponentes(Request $request)
    {
        if ($request->hasFile('archivo')) {
            $request->validate([
                'archivo' => 'required|mimes:xlsx,xls|max:2048',
            ]);

            $archivo = $request->file('archivo');
            $archivo->move(public_path('Excels'), $archivo->getClientOriginalName());
            $filePath = public_path('Excels') . '/' . $archivo->getClientOriginalName();

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $chunkSize = 1000;
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            // Procesar filas en bloques para evitar problemas de memoria
            for ($startRow = 2; $startRow <= $highestRow; $startRow += $chunkSize) { // Comenzar desde la fila 2 para saltar la primera fila
                $endRow = min($startRow + $chunkSize - 1, $highestRow);

                for ($row = $startRow; $row <= $endRow; $row++) {
                    $data = [];
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $cellValue = $worksheet->getCell($col . $row)->getValue();
                        $data[] = $cellValue;
                    }

                    if (!empty($data[0]) && count($data) >= 4) {
                        // Guardar los datos en la base de datos
                        $transaccionC = new TransaccionComponentes();
                        $transaccionC->codigo_bien = $data[0];
                        $transaccionC->codigo_bien_compuesto = $data[1];
                        $transaccionC->tipo = $data[2];
                        $transaccionC->descripcion = $data[3];
                        $transaccionC->save();
                    }
                }
            }

            // Registrar el historial del archivo subido
            ArchivoHistorial::create([
                'usuario' => Auth::user()->name,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'fecha_subida' => now(),
            ]);

            return Redirect::back()->with('success', 'Archivo subido correctamente');
        }

        return Redirect::back()->with('error', 'No se ha enviado ningún archivo');
    }

    public function historialCarga()
    {
        // Obtener el historial de archivos subidos
        $historial = ArchivoHistorial::all();
        return view('reporte.historial-carga', compact('historial'));
    }
}
