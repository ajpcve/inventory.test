<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetSaleInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_sale_inventory', function (Blueprint $table) {
            $table->increments('id_dsale_inventory');
            $table->integer('id_item')->unsigned();
            $table->foreign('id_item')->references('id_item')->on('item');
            $table->string('dsaleinv_lot');
            $table->double('dsaleinv_qty');
            $table->integer('id_csale_inventory')->unsigned();
            $table->foreign('id_csale_inventory')->references('id_csale_inventory')->on('cab_sale_inventory');
            $table->integer('id_warehouse')->unsigned();
            $table->foreign('id_warehouse')->references('id_warehouse')->on('warehouse');
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
        Schema::dropIfExists('det_sale_inventory');
    }
}
