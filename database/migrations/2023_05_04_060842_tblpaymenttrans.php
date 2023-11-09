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
        Schema::create('tblpaymenttrans', function (Blueprint $table) {
            $table->string('notrans');
            $table->foreign('notrans')->references('notrans')->on('tbltrans');
            $table->unsignedInteger('paymentid');
            $table->foreign('paymentid')->references('paymentid')->on('tblpaymentmethod');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->boolean('pelunasanOlehPemilik')->default(0);
            $table->date('tglBayar');
            $table->date('tglVerifikasi')->nullable();
            $table->double('total')->default(0.00);
            $table->double('totalPay')->default(0.00);
            $table->string('payment_type')->nullable();
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
            $table->primary(['paymentid', 'notrans']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblpaymenttrans');
    }
};
