<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetInboundOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_inbound_orders', function (Blueprint $table) {
            $table->increments('id_diord');
            $table->string('diord_pallet')->nullable();
            $table->string('diord_item_code')->nullable();
            $table->string('diord_lot')->nullable();
            $table->double('diord_qty')->nullable();
            $table->date('diord_expiration_date')->nullable();
            $table->integer('id_ciord')->unsigned()->nullable();
            $table->foreign('id_ciord')->references('id_ciord')->on('cab_inbound_orders');
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
        Schema::dropIfExists('det_inbound_orders');
    }
}
