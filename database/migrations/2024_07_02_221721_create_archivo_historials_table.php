<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivoHistorialsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql')->create('archivo_historials', function (Blueprint $table) {
            $table->id();
            $table->string('usuario');
            $table->string('nombre_archivo');
            $table->timestamp('fecha_subida');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql')->dropIfExists('archivo_historials');
    }
}
