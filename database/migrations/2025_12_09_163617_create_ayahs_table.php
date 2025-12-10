<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surah_id')->constrained('surahs')->onDelete('cascade'); // relasi ke surahs
            $table->integer('ayah_number');         // nomor ayat
            $table->text('text_arab');             // teks arab
            $table->text('translation_id')->nullable(); // terjemahan bahasa indonesia
            $table->longText('tafsir_id')->nullable();  // tafsir
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayahs');
    }
};
