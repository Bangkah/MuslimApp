<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('surahs', function (Blueprint $table) {
        $table->id();
        $table->integer('number');
        $table->string('name_ar');
        $table->string('name_en');
        $table->string('name_id');
        $table->string('revelation');
        $table->integer('ayah_count');
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('surahs');
    }
};