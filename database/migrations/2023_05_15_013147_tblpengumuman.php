<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblpengumuman', function (Blueprint $table) {
            $table->increments('pengumumanid');
            $table->unsignedInteger('companyid');
            $table->foreign('companyid')->references('companyid')->on('tblcomp');
            $table->text('judul')->nullable();
            $table->text('pengumuman')->nullable();
            $table->boolean('isPengumumanCompany')->default(0);
            $table->text('polling')->nullable();
            $table->text('usersRead')->nullable();
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
        Schema::dropIfExists('tblpengumuman');
    }
};
