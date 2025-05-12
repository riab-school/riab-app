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
        Schema::create('clasroom_tahfidz_head_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('classroom_id')->constrained('master_classrooms')->onUpdate('cascade')->onDelete('cascade')->nullable();
            
            $table->string('head_tahfidz_id')->nullable();
            $table->foreign('head_tahfidz_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('tahun_ajaran_id')->constrained('master_tahun_ajarans')->onUpdate('cascade')->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clasroom_tahfidz_head_histories');
    }
};
