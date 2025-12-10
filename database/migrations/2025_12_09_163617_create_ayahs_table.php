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
    Schema::create('ayahs', function (Blueprint $table) {
        $table->id();
        $table->integer('surah_id');
        $table->integer('number');
        $table->text('text_ar');
        $table->text('text_id')->nullable();
        $table->text('tafsir')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayahs');
    }
};
