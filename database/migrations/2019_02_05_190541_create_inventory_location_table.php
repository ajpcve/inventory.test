<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_location', function (Blueprint $table) {
            $table->increments('id_inventory_location');
            $table->double('inv_location_qty');
            $table->integer('id_warehouse')->unsigned();
            $table->foreign('id_warehouse')->references('id_warehouse')->on('warehouse');
            $table->integer('id_inv')->unsigned();
            $table->foreign('id_inv')->references('id_inv')->on('inventory');
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
        Schema::dropIfExists('inventory_location');
    }
}
