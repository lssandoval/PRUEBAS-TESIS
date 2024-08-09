<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTecnologicasTable extends Migration
{
    public function up()
    {
        Schema::create('asistencias_tecnologicas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_requerimiento');
            $table->string('solicitante');
            $table->date('fecha_solicitud');
            $table->string('tipo_bien');
            $table->foreignId('estado_id')->constrained('estados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias_tecnologicas');
    }
}