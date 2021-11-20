<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->index()->cascadeOnDelete();
            $table->string('nombre');
            $table->string('slug');
            $table->text('detalles')->nullable();
            $table->dateTime('fechaHoraFinalizacion');
            $table->string('lugar');
            $table->integer('cuantosFaltan');
            $table->integer('tipoDeCancha');
            $table->float('precio', 6, 2);
            $table->string('estado');
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
        Schema::dropIfExists('partidos');
    }
}
