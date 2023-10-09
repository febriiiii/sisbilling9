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
        // Schema::create('tblcustomer', function (Blueprint $table) {
        //     $table->increments('customerid');
        //     $table->unsignedInteger('companyid');
        //     $table->foreign('companyid')->references('companyid')->on('tblcomp');
        //     $table->unsignedInteger('statusid');
        //     $table->foreign('statusid')->references('statusid')->on('tblstatus');
        //     $table->unsignedInteger('userid');
        //     $table->foreign('userid')->references('userid')->on('tbluser');
        //     $table->string('email')->unique();
        //     $table->string('nama');
        //     $table->string('hp');
        //     $table->string('alamatSingkat');
        //     $table->text('alamatLengkap');
        //     $table->text('infoTambahan')->nullable();
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
        Schema::dropIfExists('tblcustomer');
    }
};
