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
        Schema::create('tblpaketuser', function (Blueprint $table) {
            $table->increments('idpaketuser');
            $table->unsignedInteger('userid');
            $table->foreign('userid')->references('userid')->on('tbluser');
            $table->unsignedInteger('idpaketakun');
            $table->foreign('idpaketakun')->references('idpaketakun')->on('tblpaketakun');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblpaketuser');
    }
};
