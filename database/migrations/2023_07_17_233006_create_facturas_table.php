<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id_factura');
            $table->integer('cedula')->unique();
            $table->unsignedBigInteger('id_usuario');
            $table->date('fecha_fac');
            $table->float('subtotal_fac');
            $table->float('descuento')->nullable();
            $table->float('iva');
            $table->float('total');
            $table->timestamps();

            $table->foreign('cedula')->references('cedula')->on('clientes');
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
