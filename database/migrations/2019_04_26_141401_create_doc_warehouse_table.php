<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_warehouse', function (Blueprint $table) {
            $table->increments('id_docwarehouse');
            $table->string('docware_ruta')->nullable();
            $table->integer('docware_pallet')->nullable();
            $table->string('docware_lot')->nullable();
            $table->integer('docware_inborders');
            $table->integer('id_doc')->unsigned()->nullable();
            $table->foreign('id_doc')->references('id_doc')->on('documents');
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
        Schema::dropIfExists('doc_warehouse');
    }
}
