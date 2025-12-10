<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surahs', function (Blueprint $table) {
    $table->id();
    $table->integer('number');
    $table->string('name');
    $table->string('name_latin');
    $table->integer('number_of_ayah');
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('surahs');
    }
};