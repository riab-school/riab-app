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
        Schema::create('master_generation_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number');
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->longText('description')->nullable();
            $table->year('year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_generation_lists');
    }
};
