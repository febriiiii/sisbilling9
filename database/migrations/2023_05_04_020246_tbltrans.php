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
        Schema::create('tbltrans', function (Blueprint $table) {
            $table->string('notrans')->primary();
            $table->unsignedInteger('companyid');
            $table->foreign('companyid')->references('companyid')->on('tblcomp');
            $table->unsignedInteger('userid');
            $table->foreign('userid')->references('userid')->on('tbluser');
            $table->unsignedInteger('AppointmentId');
            $table->foreign('AppointmentId')->references('AppointmentId')->on('tblagenda');
            $table->unsignedInteger('paymentid')->nullable();
            $table->foreign('paymentid')->references('paymentid')->on('tblpaymentmethod');
            $table->dateTime('transdate');
            $table->dateTime('jatuhTempoTagihan');
            $table->double('SisaPok');
            $table->double('Pokok');
            $table->double('Bunga');
            $table->double('LateFee');
            $table->integer('JHT')->nullable();
            $table->double('SPokok')->nullable();
            $table->double('SBunga')->nullable();
            $table->double('SLateFee')->nullable();
            $table->double('SisaCCL')->nullable();
            $table->string('KodePay')->default('T');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->string('isreject')->default(0);
            $table->string('snap_token')->nullable();
            $table->string('MIDstatus')->nullable();
            $table->string('MIDstatusmsg')->nullable();
            $table->string('MIDpaymenttype')->nullable();
            $table->string('MIDUpdateUser')->nullable();
            $table->text('MIDall')->nullable();
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
        Schema::dropIfExists('tbltrans');
    }
};
