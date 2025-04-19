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
        Schema::create('master_classrooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable()->unique();
            $table->enum('focus', ['mipa', 'agama', 'others'])->nullable();
            $table->enum('grade', ['X', 'XI', 'XII'])->nullable();
            $table->integer('number')->nullable();
            $table->string('limitation')->nullable();
            $table->string('location')->nullable();

            $table->string('head_id')->nullable();
            $table->foreign('head_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');

            $table->string('head_tahfidz_id')->nullable();
            $table->foreign('head_tahfidz_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_classrooms');
    }
};
