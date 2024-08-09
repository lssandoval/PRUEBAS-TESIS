<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'distributivo.persona';
    protected $primaryKey = 'per_id';
    protected $connection = 'pgsql2';

    protected $fillable = ['per_unidad', 'per_cedula'];

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class, 'distributivo.persona_area', 'per_id', 'are_id');
    }

    public function getUnidadAttribute()
    {
        return $this->attributes['per_unidad'];
    }

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'per_id', 'per_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'cedula', 'per_cedula');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'are_id', 'are_id');
    }
}
