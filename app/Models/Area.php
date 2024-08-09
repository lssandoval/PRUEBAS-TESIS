<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Area extends Model
{
    use HasFactory;
    
    protected $table = 'distributivo.area';
    protected $primaryKey = 'are_id';
    protected $connection = 'pgsql2';

    public function personas(): BelongsToMany
    {
        return $this->belongsToMany(Persona::class, 'distributivo.persona_area', 'are_id', 'per_id');
    }
}
