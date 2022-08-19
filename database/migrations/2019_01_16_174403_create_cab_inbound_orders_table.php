<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabInboundOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cab_inbound_orders', function (Blueprint $table) {
            $table->increments('id_ciord');
            $table->date('ciord_date')->nullable();
            $table->date('ciord_export_date')->nullable();
            $table->string('ciord_guia_aerea')->nullable();
            $table->string('ciord_orden_compra')->nullable();
            $table->integer('id_warehouse')->unsigned()->nullable();
            $table->foreign('id_warehouse')->references('id_warehouse')->on('warehouse');
            $table->integer('id_status')->unsigned()->nullable();
            $table->foreign('id_status')->references('id_status')->on('status');
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
        Schema::dropIfExists('cab_inbound_orders');
    }
}
