<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocInboundOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_inbound_orders', function (Blueprint $table) {
            $table->increments('id_dociord');
            $table->string('dociord_ruta')->nullable();
            $table->integer('dociord_pallet')->nullable();
            $table->integer('id_doc')->unsigned()->nullable();
            $table->foreign('id_doc')->references('id_doc')->on('documents');
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
        Schema::dropIfExists('doc_inbound_orders');
    }
}
