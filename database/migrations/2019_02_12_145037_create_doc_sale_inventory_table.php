<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocSaleInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_sale_inventory', function (Blueprint $table) {
            $table->increments('id_docsinven');
            $table->string('docsinven_ruta')->nullable();
            $table->integer('id_doc')->unsigned()->nullable();
            $table->foreign('id_doc')->references('id_doc')->on('documents');
            $table->integer('id_csale_inventory')->unsigned()->nullable();
            $table->foreign('id_csale_inventory')->references('id_csale_inventory')->on('cab_sale_inventory');
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
        Schema::dropIfExists('doc_sale_inventory');
    }
}
