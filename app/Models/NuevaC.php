<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NuevaC extends Model
{
    protected $table = 'nuevaC'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $incrementing = true; // Define si la clave primaria es auto-incremental
    protected $fillable = [
        'codigo_bien',
        'codigo_bien_compuesto',
        'tipoC',
        'descripcionC',
        'accionC'
    ];

    // Relación de pertenencia con la tabla nuevat
    public function nuevat()
    {
        return $this->belongsTo(Nuevat::class, 'codigo_bien', 'codigo_bien');
    }
}
