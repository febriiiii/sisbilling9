<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblkomentar', function (Blueprint $table) {
            $table->increments('komentarid');
            $table->unsignedInteger('statusid');
            $table->foreign('statusid')->references('statusid')->on('tblstatus');
            $table->unsignedInteger('pengumumanid');
            $table->foreign('pengumumanid')->references('pengumumanid')->on('tblpengumuman');
            $table->text('pesan');
            $table->text('userid');
            $table->string('UserInsert')->nullable();
            $table->dateTime('InsertDT')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->dateTime('UpdateDT')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblkomentar');
    }
};
