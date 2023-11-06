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
        Schema::create('tblmasterproduct', function (Blueprint $table) {
            $table->increments('productCode');
            $table->unsignedInteger('companyid'); //$table->integer('companyid');
            // $table->primary(['productCode', 'companyid']);
            $table->foreign('companyid')->references('companyid')->on('tblcomp');
            $table->string('productName');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->unsignedInteger('producttypeid');
            $table->foreign('producttypeid')->references('producttypeid')->on('tblproducttype');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();

            // Subscribe
            $table->boolean('isSubscribe')->default(0);
            $table->double('price')->nullable();
            $table->double('disc')->nullable();
            $table->string('rangeDuration')->nullable();
            $table->string('duration')->nullable();
        });
        // DURATION Hari/Minggu/Bulan/Tahun
        // 1. Free Trial 7 hari - Rp 0 (Diskon 100%)
        // 2. Paket Bulanan - Tenor 30hari - Rp 100rb (Diskon 80% dari Rp.500rb/bln)
        // 3. Paket TriWulan - Tenor 90hari - Rp 225rb (Diskon 85% dari Rp.500rb/bln)
        // 4. Paket Semester - Tenor 180 hari -Rp 360rb (Diskon 88% dari Rp.500rb/bln)
        // 5. Paket Tahunan - Tenor 360 hari - Rp 600rb (Diskon 90% dari Rp.500rb/bln
        DB::table('tblmasterproduct')->insert([
            'companyid' => 1,
            'productName' => 'Free Trial 7 hari',
            'statusid' => 1,
            'producttypeid' => 1,
            'isSubscribe' => 1,
            'price' => 0,
            'disc' => 0,
            'rangeDuration' => 7,
            'duration' => 'Hari',
            'UserInsert' => 'system',
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);
        DB::table('tblmasterproduct')->insert([
            'companyid' => 1,
            'productName' => 'Paket Bulanan',
            'statusid' => 1,
            'producttypeid' => 1,
            'isSubscribe' => 1,
            'price' => 500000,
            'disc' => 80,
            'rangeDuration' => 1,
            'duration' => 'Bulan',
            'UserInsert' => 'system',
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);
        DB::table('tblmasterproduct')->insert([
            'companyid' => 1,
            'productName' => 'Paket TriWulan',
            'statusid' => 1,
            'producttypeid' => 1,
            'isSubscribe' => 1,
            'price' => 1500000,
            'disc' => 85,
            'rangeDuration' => 3,
            'duration' => 'Bulan',
            'UserInsert' => 'system',
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);
        DB::table('tblmasterproduct')->insert([
            'companyid' => 1,
            'productName' => 'Paket Semester',
            'statusid' => 1,
            'producttypeid' => 1,
            'isSubscribe' => 1,
            'price' => 3000000,
            'disc' => 88,
            'rangeDuration' => 6,
            'duration' => 'Bulan',
            'UserInsert' => 'system',
            'InsertDT' => now(),
            'UserUpdate' => 'system',
            'UpdateDT' => now(),
        ]);
        DB::table('tblmasterproduct')->insert([
            'companyid' => 1,
            'productName' => 'Paket Tahunan',
            'statusid' => 1,
            'producttypeid' => 1,
            'isSubscribe' => 1,
            'price' => 6000000,
            'disc' => 90,
            'rangeDuration' => 1,
            'duration' => 'Tahun',
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
        Schema::dropIfExists('tblmasterproduct');
    }
};
