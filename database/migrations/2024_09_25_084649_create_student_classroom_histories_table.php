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
        Schema::create('student_classroom_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('tahun_ajaran_id')->constrained('master_tahun_ajarans')->onDelete('cascade')->onUpdate('cascade')->nullable();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('classroom_id')->constrained('master_classrooms')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_classroom_histories');
    }
};
