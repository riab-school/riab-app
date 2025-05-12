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
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->enum('focus', ['mipa', 'agama', 'others'])->nullable();
            $table->enum('grade', ['X', 'XI', 'XII'])->nullable();
            $table->integer('number')->nullable();
            $table->string('limitation')->nullable();
            $table->string('location')->nullable();

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
