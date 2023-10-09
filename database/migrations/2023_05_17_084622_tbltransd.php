<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('tbltransd', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('notrans');
        //     $table->foreign('notrans')->references('notrans')->on('tbltrans');
        //     $table->string('productCode');
        //     $table->double('price');
        //     $table->unsignedInteger('statusid');
        //     $table->foreign('statusid')->references('statusid')->on('tblstatus');
        //     $table->string('UserInsert')->nullable();
        //     $table->dateTime('InsertDT')->nullable();
        //     $table->string('UserUpdate')->nullable();
        //     $table->dateTime('UpdateDT')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('tbltransd');
    }
};
