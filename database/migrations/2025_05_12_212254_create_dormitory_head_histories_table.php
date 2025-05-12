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
        Schema::create('dormitory_head_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('dormitory_id')->nullable();
            $table->foreign('dormitory_id')->references('id')->on('master_dormitories')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('head_id')->nullable();
            $table->foreign('head_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('tahun_ajaran_id')->nullable();
            $table->foreign('tahun_ajaran_id')->references('id')->on('master_tahun_ajarans')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dormitory_head_histories');
    }
};
