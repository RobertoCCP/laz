<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 10)->unique();
            $table->text('nombre');
            $table->text('apellido');
            $table->text('correo');
            $table->text('telefono');
            $table->timestamps();
        });
        
        // Agregar índice a la columna 'cedula'
        Schema::table('clientes', function (Blueprint $table) {
            $table->index('cedula');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
