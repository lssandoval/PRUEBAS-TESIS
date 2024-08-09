<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoHistorial extends Model
{
    use HasFactory;

    protected $fillable = ['usuario', 'nombre_archivo', 'fecha_subida'];
}
