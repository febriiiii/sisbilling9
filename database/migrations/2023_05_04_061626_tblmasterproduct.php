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
        Schema::create('tblmasterproduct', function (Blueprint $table) {
            $table->string('productCode');
            $table->unsignedInteger('companyid'); //$table->integer('companyid');
            $table->primary(['productCode', 'companyid']);
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblmasterproduct');
    }
};
