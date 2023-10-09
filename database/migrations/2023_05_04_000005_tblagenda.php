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
        Schema::create('tblagenda', function (Blueprint $table) {
            $table->increments('AppointmentId');
            $table->string('Text');
            $table->dateTime('StartDate');
            $table->dateTime('EndDate');
            $table->text('description')->nullable();
            $table->string('all_day')->nullable();
            $table->string('RecurrenceRule')->nullable();
            $table->string('RecurrenceException')->nullable();
            $table->unsignedInteger('companyid')->nullable();
            $table->string('isBilling')->default(0);
            $table->string('productCode')->nullable();
            $table->double('Pokok');
            $table->double('lateFeePercent');
            $table->double('BungaPercent');
            $table->unsignedInteger('userid');
            $table->foreign('userid')->references('userid')->on('tbluser');
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
        Schema::dropIfExists('tblagenda');
    }
};
