<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabSaleInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cab_sale_inventory', function (Blueprint $table) {
            $table->increments('id_csale_inventory');
            $table->date('csaleinv_date');
            $table->string('csaleinv_invoice');
            $table->string('csaleinv_or_num');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id_customer')->on('customer');
            $table->integer('id_users')->unsigned();
            $table->foreign('id_users')->references('id')->on('users');
            $table->string('csaleinv_tran_cust')->nullable();
            $table->integer('csaleinv_transport');
            $table->string('csaleinv_driver_name')->nullable();
            $table->string('csaleinv_driver_phone')->nullable();
            $table->date('csaleinv_date_pick_up')->nullable();
            $table->time('csaleinv_date_time')->nullable();
            $table->date('csaleinv_date_delivery')->nullable();
            $table->string('csaleinv_appointment_selet');
            $table->time('csaleinv_appointment')->nullable();

            $table->integer('id_delivery')->nullable();
            $table->string('csaleinv_deli_name')->nullable();
            $table->string('csaleinv_deli_phone')->nullable();
            $table->string('csaleinv_deli_email')->nullable();
            $table->string('csaleinv_deli_address')->nullable();

            $table->string('csaleinv_chep_pallet')->nullable();
            $table->string('csaleinv_shrink_wrap')->nullable();
            $table->string('csaleinv_palletization')->nullable();
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
        Schema::dropIfExists('cab_sale_inventory');
    }
}
