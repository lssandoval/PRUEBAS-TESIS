<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->bigIncrements('id_mantenimiento'); // Clave primaria
            $table->string('codigo_bien')->nullable(); // Código del Bien
            $table->string('tipo_bien')->nullable(); // Tipo de Bien
            $table->string('uso_bien')->nullable(); // Uso del Bien
            $table->string('custodio_bien')->nullable(); // Custodio del Bien
            $table->date('fecha_mantenimiento')->nullable(); // Hora de Inicio
            $table->time('hora_inicio')->nullable(); // Hora de Inicio
            $table->time('hora_fin')->nullable(); // Hora de Finalización
            $table->string('tecnico_asignado')->nullable(); // Técnico Asignado
            $table->unsignedBigInteger('id_nuevat')->nullable(); // Relación con Nuevat

            // Añadir índices y claves foráneas
            $table->foreign('id_nuevat')->references('id')->on('nuevat')->onDelete('set null');

            $table->timestamps(); // Para created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('mantenimientos');
    }
}
