<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaccionComponentes extends Model
{
    protected $table = 'nuevaC'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla

    // Aquí puedes especificar los campos que puedes rellenar
    protected $fillable = [
        'codigo_bien',
        'codigo_bien_compuesto',
        'tipo',
        'descripcion',
    ];
}
