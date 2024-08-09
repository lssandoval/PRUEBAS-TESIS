<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaPersona extends Model
{
    use HasFactory;
    protected $table = 'distributivo.persona_area';
    protected $primaryKey = 'par_id';

    protected $connection = 'pgsql2';
}
