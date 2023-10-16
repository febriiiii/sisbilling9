<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tblsyspara', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('sysDate')->nullable();
        });
        DB::table('tblsyspara')->insert([
            'sysDate' => null,
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tblsyspara');
    }
};
