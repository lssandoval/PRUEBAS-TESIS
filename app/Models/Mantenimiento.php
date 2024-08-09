<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_mantenimiento'; // Clave primaria de la tabla

    // Aquí puedes especificar los campos que puedes rellenar
    protected $fillable = [
        'codigo_bien',
        'tipo_bien',
        'uso_bien',
        'custodio_bien',
        'fecha_mantenimiento',
        'hora_inicio',
        'hora_fin',
        'tecnico_asignado',
        'id_nuevat'
    ];

    // Relación con el modelo Nuevat
    public function nuevat()
    {
        return $this->belongsTo(Nuevat::class, 'id_nuevat', 'id');
    }
}
