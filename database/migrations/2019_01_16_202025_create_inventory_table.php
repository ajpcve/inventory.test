<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id_inv');
            $table->date('inv_date');
            $table->string('inv_pallet');
            $table->integer('inv_inborders');
            $table->string('inv_lot');
            $table->integer('id_item')->unsigned();
            $table->foreign('id_item')->references('id_item')->on('item');
            $table->integer('id_status')->unsigned();
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
        Schema::dropIfExists('inventory');
    }
}
