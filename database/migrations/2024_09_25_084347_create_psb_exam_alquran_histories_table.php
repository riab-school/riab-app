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
        Schema::create('psb_exam_alquran_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_configs_id');
            $table->foreign('psb_configs_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('khatak_jali');
            $table->integer('khatak_kafi');
            $table->integer('total_skor');
            $table->integer('jumlah_hafalan');
            $table->string('kualitas_hafalan');
            $table->string('rekomendasi_hafalan');
            $table->string('rekomendasi_bacaan');
            $table->longText('keterangan_hafalan');

            $table->string('tested_by')->nullable();
            $table->foreign('tested_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_exam_alquran_histories');
    }
};
