<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nuevat extends Model
{
    protected $table = 'nuevat'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $incrementing = true; // Define si la clave primaria es auto-incremental
    protected $fillable = [
        'codigo_bien',
        'en_uso',
        'tipo',
        'marca',
        'modelo',
        'serial',
        'ubicacion',
        'custodio_identificado',
        'fecha_ingreso',
        'periodo_garantia',
        'proveedor',
        'estado',
        'fecha_ultimo_mantenimiento',
        'recomendacion_1',
        'recomendacion_2',
        'cedula_esbye',
        'custodio_esbye',
        'serial_esbye',
        'modelo_esbye',
        'descripcion_esbye'
    ];

    // Relación uno a muchos con la tabla nuevaC
    public function nuevaCs()
    {
        return $this->hasMany(NuevaC::class, 'codigo_bien', 'codigo_bien');
    }
}
