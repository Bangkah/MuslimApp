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
    $table->foreignId('surah_id')->constrained('surahs')->onDelete('cascade');
    $table->integer('ayah_number');
    $table->text('text_arab');
    $table->text('translation_id')->nullable();
    $table->longText('tafsir_id')->nullable();
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
