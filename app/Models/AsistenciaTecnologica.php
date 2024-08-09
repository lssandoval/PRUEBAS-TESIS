<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaTecnologica extends Model
{
    use HasFactory;
    protected $table = 'asistencias_tecnologicas'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'tipo_requerimiento',
        'solicitante',
        'fecha_solicitud',
        'tipo_bien',
        'estado_id',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime', // Esto asegura que se maneje como un objeto Carbon
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    /**
     * Determina si la asistencia tecnológica puede asignar un técnico.
     *
     * @return bool
     */
    public function canAssignTechnician()
    {
        return $this->estado->id === 1; // 'En Espera'
    }

    /**
     * Determina si la asistencia tecnológica puede ingresar una solución.
     *
     * @return bool
     */
    public function canEnterSolution()
    {
        return $this->estado->id === 2; // 'Asignado'
    }

    /**
     * Determina si la asistencia tecnológica puede generar un informe.
     *
     * @return bool
     */
    public function canGenerateReport()
    {
        return $this->estado->id === 3; // 'Ejecutado'
    }
}
