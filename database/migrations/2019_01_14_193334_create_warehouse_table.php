<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->increments('id_warehouse');
            $table->string('house_name');
            $table->string('house_address');
            $table->string('house_phone');
            $table->string('house_phone_two')->nullable();
            $table->string('house_person');
            $table->string('house_description');
            $table->string('house_email');
            $table->string('house_email_two')->nullable();
            $table->string('house_email_three')->nullable();
            $table->string('house_activity');
            $table->integer('house_step')->nullable();
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
        Schema::dropIfExists('warehouse');
    }
}
