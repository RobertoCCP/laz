<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id_pedido');
            $table->unsignedBigInteger('id_tipo_servicio');
            $table->unsignedInteger('id_factura');
            $table->date('fecha_salida')->nullable();
            $table->integer('cantidad');
            $table->float('sub_total');
            $table->timestamps();

            $table->foreign('id_tipo_servicio')->references('id')->on('servicios');
            $table->foreign('id_factura')->references('id_factura')->on('facturas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
