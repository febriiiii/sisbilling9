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
        Schema::create('tblcomp', function (Blueprint $table) {
            $table->increments('companyid');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->string('companyname');
            $table->text('companyaddress');
            $table->string('email');
            $table->string('hp');
            $table->string('producttypeArray');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });

        DB::table('tblcomp')->insert([
            'companyname' => 'Suport Center',
            'statusid' => 1,
            'UserInsert' => 'system',
            'email' => 'gksdev@gks.co.id',
            'hp' => '123456789',
            'companyaddress' => 'www.gks.co.id',
            'producttypeArray' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblcomp');
    }
};
