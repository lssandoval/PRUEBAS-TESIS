<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('pgsql')->create('nuevat', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_bien')->unique()->nullable(); // Hacer que la columna sea única
            $table->string('en_uso')->default(false);
            $table->string('tipo')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serial')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('custodio_identificado')->nullable();
            $table->string('fecha_ingreso')->nullable();
            $table->string('periodo_garantia')->nullable();
            $table->string('proveedor')->nullable();
            $table->string('estado')->nullable();
            $table->string('fecha_ultimo_mantenimiento')->nullable();
            $table->string('recomendacion_1')->nullable();
            $table->string('recomendacion_2')->nullable();
            $table->string('cedula_esbye')->nullable();
            $table->string('custodio_esbye')->nullable();
            $table->string('serial_esbye')->nullable();
            $table->string('modelo_esbye')->nullable();
            $table->string('descripcion_esbye')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql')->dropIfExists('nuevat');
    }
};
