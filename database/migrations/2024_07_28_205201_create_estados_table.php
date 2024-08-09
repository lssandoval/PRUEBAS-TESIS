<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosTable extends Migration
{
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // Insertar los estados iniciales
        DB::table('estados')->insert([
            ['nombre' => 'EN ESPERA'],
            ['nombre' => 'ASIGNADO'],
            ['nombre' => 'EJECUTADO'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('estados');
    }
}