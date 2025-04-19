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
        Schema::create('student_dormitory_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('tahun_ajaran_id')->nullable();
            $table->foreign('tahun_ajaran_id')->references('id')->on('master_tahun_ajarans')->onDelete('SET NULL');

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('dormitory_id');
            $table->foreign('dormitory_id')->references('id')->on('master_dormitories')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('is_mudabbir')->default('0')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_dormitory_histories');
    }
};
