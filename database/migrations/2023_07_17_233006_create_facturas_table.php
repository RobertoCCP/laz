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
            $table->string('cedula', 10)->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->date('fecha_fac');
            $table->double('subtotal_fac', 8, 2);
            $table->double('descuento', 8, 2)->nullable();
            $table->double('iva', 8, 2);
            $table->double('total', 8, 2);
            $table->timestamps();

            $table->foreign('cedula')->references('cedula')->on('clientes')->onDelete('set null');
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
