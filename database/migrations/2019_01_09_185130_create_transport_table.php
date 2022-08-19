<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport', function (Blueprint $table) {
            $table->increments('id_transport');
            $table->string('trans_company');
            $table->string('trans_phone');
            $table->string('trans_address')->nullable();
            $table->string('trans_email');
            $table->string('trans_contact');
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
        Schema::dropIfExists('transport');
    }
}
