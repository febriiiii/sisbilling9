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
        Schema::create('tblstatus', function (Blueprint $table) {
            $table->increments('statusid');
            $table->string('deskripsi');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });
        
        DB::table('tblstatus')->insert([
            ['deskripsi' => 'Default'],
            ['deskripsi' => 'park'],
            ['deskripsi' => 'Canled'],
            ['deskripsi' => 'Delete'],
            ['deskripsi' => 'Belum Diproses'],
            ['deskripsi' => 'Sedang Diproses Manual'],
            ['deskripsi' => 'Paid'],
            ['deskripsi' => 'Ditolak'],
            ['deskripsi' => 'read'],
            ['deskripsi' => 'Expired'],
            ['deskripsi' => 'Pending Midtrans'],
            ['deskripsi' => 'Transaction Rollback'],
            ['deskripsi' => 'Void Transaksi'],
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblstatus');
    }
};
