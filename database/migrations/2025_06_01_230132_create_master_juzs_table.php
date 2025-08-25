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
        Schema::create('master_juzs', function (Blueprint $table) {
            $table->id();
            $table->integer('juz')->unique();
            $table->integer('from_surah');
            $table->integer('from_ayat');
            $table->integer('to_surah');
            $table->integer('to_ayat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_juzs');
    }
};
