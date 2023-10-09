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
        Schema::create('tblproducttype', function (Blueprint $table) {
            $table->increments('producttypeid');
            $table->unsignedInteger('companyid');
            $table->foreign('companyid')->references('companyid')->on('tblcomp');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->string('productTypeName');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });

        DB::table('tblproducttype')->insert([
            [
            'companyid' => 1,
            'statusid' => 1,
            'productTypeName' => 'Produk Jasa',
            'UserInsert' => 1,
            'InsertDT' => now(),
            'UserUpdate' => 1,
            'UpdateDT' => now()
            ],
            [
                'companyid' => 1,
                'statusid' => 1,
                'productTypeName' => 'Pinjaman Berjanka',
                'UserInsert' => 1,
                'InsertDT' => now(),
                'UserUpdate' => 1,
                'UpdateDT' => now()
            ],
            [
                'companyid' => 1,
                'statusid' => 1,
                'productTypeName' => 'Produk Digital',
                'UserInsert' => 1,
                'InsertDT' => now(),
                'UserUpdate' => 1,
                'UpdateDT' => now()
            ],
            [
                'companyid' => 1,
                'statusid' => 1,
                'productTypeName' => 'Produk Fisik',
                'UserInsert' => 1,
                'InsertDT' => now(),
                'UserUpdate' => 1,
                'UpdateDT' => now()
            ],
            [
                'companyid' => 1,
                'statusid' => 1,
                'productTypeName' => 'Produk Campuran',
                'UserInsert' => 1,
                'InsertDT' => now(),
                'UserUpdate' => 1,
                'UpdateDT' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblproducttype');
    }
};
