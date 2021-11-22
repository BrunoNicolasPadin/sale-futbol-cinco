<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalificacionesPartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones_partidos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignUuid('partido_id')->index()->constrained('partidos')->onDelete('cascade');
            $table->integer('puntaje');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones_partidos');
    }
}
