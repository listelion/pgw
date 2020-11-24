<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('addr_no');
            $table->string('send_name');
            $table->string('send_addr');
            $table->string('send_num1');
            $table->string('send_num2');
            $table->string('send_num3');
            $table->string('repi_name');
            $table->string('repi_num1');
            $table->string('repi_num2');
            $table->string('repi_num3');
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
        Schema::dropIfExists('address');
    }
}
