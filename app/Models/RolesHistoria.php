<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RolesHistoria extends Model
{
    protected $table = 'user_role_history'; // Define la tabla si no sigue la convención de nombres

    protected $fillable = ['user_id', 'role_id', 'created_at', 'updated_at', 'estado', 'asignador'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
