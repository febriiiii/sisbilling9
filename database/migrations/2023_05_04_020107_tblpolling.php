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
        Schema::create('tblpolling', function (Blueprint $table) {
            $table->increments('idpolling');
            $table->unsignedInteger('companyid');
            $table->foreign('companyid')->references('companyid')->on('tblcomp');
            $table->boolean('isSetuju');
            $table->string('additionalSetuju')->nullable();
            $table->text('deskripsi');
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
     */
    public function down(): void
    {
        Schema::dropIfExists('tblpolling');
    }
};
