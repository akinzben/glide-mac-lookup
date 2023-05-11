<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOUIRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_u_i_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Registry');
            $table->string('Assignment');
            $table->string('Organization_Name');
            $table->string('Organization_Address');
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
        Schema::dropIfExists('o_u_i_records');
    }
}
