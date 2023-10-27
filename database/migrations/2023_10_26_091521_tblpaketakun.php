<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblpaketakun', function (Blueprint $table) {
            $table->increments('idpaketakun');
            $table->string('billname');
            $table->double('price');
            $table->string('rangeDuration');
            $table->string('duration');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });

        // D/M/Y
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblpaketakun');
    }
};
