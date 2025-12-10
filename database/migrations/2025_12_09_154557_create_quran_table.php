<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quran', function (Blueprint $table) {
        $table->id();
        $table->unsignedTinyInteger('surah');
        $table->unsignedSmallInteger('ayah');
        $table->text('arabic');
        $table->text('translation_id');
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('quran');
    }
};