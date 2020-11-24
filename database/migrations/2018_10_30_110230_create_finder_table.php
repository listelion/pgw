<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finder', function (Blueprint $table) {
            $table->increments('id');
            $table->string('find_name');
            $table->string('find_num1');
            $table->string('find_num2');
            $table->string('find_num3');
            $table->string('find_addr');
            $table->string('find_addr2');
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
        Schema::dropIfExists('finder');
    }
}
