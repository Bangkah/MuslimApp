<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->string('city')->index();
            $table->date('date')->index();
            $table->time('imsak');
            $table->time('subuh');
            $table->time('terbit');
            $table->time('dhuha');
            $table->time('dzuhur');
            $table->time('ashar');
            $table->time('maghrib');
            $table->time('isya');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
    }
};
