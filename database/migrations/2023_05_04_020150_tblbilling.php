<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblbilling', function (Blueprint $table) {
            $table->increments('billingid');
            $table->unsignedInteger('userid');
            $table->foreign('userid')->references('userid')->on('tbluser');
            $table->unsignedInteger('AppointmentId');
            $table->foreign('AppointmentId')->references('AppointmentId')->on('tblagenda');
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
        Schema::dropIfExists('tblbilling');
    }
};
