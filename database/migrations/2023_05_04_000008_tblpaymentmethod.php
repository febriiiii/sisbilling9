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
        Schema::create('tblpaymentmethod', function (Blueprint $table) {
            $table->increments('paymentid');
            $table->unsignedInteger('companyid');
            $table->foreign('companyid')->references('companyid')->on('tblcomp');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->string('paymentName');
            $table->string('RekTujuan');
            $table->string('AtasNama');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });

        DB::table('tblpaymentmethod')->insert(
            [
                [
                    'companyid' => 1,
                    'statusid' => 1,
                    'paymentName' => 'Lainnya',
                    'RekTujuan' => '-',
                    'AtasNama' => '-',
                    'UserInsert' => '1',
                    'InsertDT' => now(),
                    'UserUpdate' => '1',
                    'UpdateDT' => now(),
                ],
                [
                    'companyid' => 1,
                    'statusid' => 4,
                    'paymentName' => 'Midtrans',
                    'RekTujuan' => '-',
                    'AtasNama' => '-',
                    'UserInsert' => '1',
                    'InsertDT' => now(),
                    'UserUpdate' => '1',
                    'UpdateDT' => now(),
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblpaymentmethod');
    }
};
