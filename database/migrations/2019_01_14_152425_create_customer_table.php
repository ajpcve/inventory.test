<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id_customer');
            $table->string('cust_company');
            $table->string('cust_phone');
            $table->string('cust_address');
            $table->string('cust_email');
            $table->string('cust_tax')->nullable();
            $table->string('cust_contact')->nullable();
            $table->string('cust_sucursal')->nullable();
            $table->integer('cust_num_sucursal')->nullable();
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
        Schema::dropIfExists('customer');
    }
}
