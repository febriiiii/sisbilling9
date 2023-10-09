<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbluser', function (Blueprint $table) {
            $table->increments('userid');
            $table->uuid('tokenid')->unique();
            $table->text('tokenDevice')->nullable();
            $table->string('companyidArray')->nullable();
            $table->string('companyid')->nullable();
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->boolean('superadmin')->default(0);
            $table->string('email')->unique();
            $table->text('password');
            $table->string('nama');
            $table->string('hp');
            $table->string('alamatSingkat');
            $table->text('alamatLengkap');
            $table->boolean('isTutor')->default(1);
            $table->text('infoTambahan')->nullable();
            $table->text('TokenCompany')->nullable();
            $table->text('TokenOTP')->nullable();
            $table->dateTime('OtpDT')->nullable();
            $table->string('profileImg')->nullable();
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });
        
        DB::statement("ALTER TABLE tbluser ADD DEFAULT (NEWID()) FOR tokenid");
        

        DB::table('tbluser')->insert([
            'statusid' => 1,
            'superadmin' => 1,
            'email' => 'pointad21@gmail.com',
            'nama' => 'Suport Center',
            'hp' => '6281234567890',
            'alamatSingkat' => 'Jl. Merdeka No. 10',
            'alamatLengkap' => 'Jl. Merdeka No. 10, Kota Jakarta, DKI Jakarta',
            'isTutor' => '0',
            'infoTambahan' => 'Suka memasak',
            'companyid' => 1,
            'profileImg' => 'user/user.png',
            'password' => Hash::make('admadm'),
            'UserInsert' => 'system',
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
        Schema::dropIfExists('tbluser');
    }
};
