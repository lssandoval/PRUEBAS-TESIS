<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoAndAsignadorToRolesHistoria extends Migration
{
    public function up()
    {
        Schema::table('user_role_history', function (Blueprint $table) {
            $table->boolean('estado')->default(1); // 1 para ACTIVO, 0 para INACTIVO
            $table->string('asignador')->nullable(); // Nombre del usuario que hace la asignación
        });
    }

    public function down()
    {
        Schema::table('user_role_history', function (Blueprint $table) {
            $table->dropColumn(['estado', 'asignador']);
        });
    }
}
