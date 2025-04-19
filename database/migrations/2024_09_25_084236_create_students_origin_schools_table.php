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
        Schema::create('students_origin_schools', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('origin_school')->nullable();
            $table->string('origin_school_address')->nullable();
            $table->string('origin_school_category')->nullable();
            $table->string('origin_school_npsn')->nullable();
            $table->year('origin_school_graduate')->nullable();

            $table->boolean('is_completed')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_origin_schools');
    }
};
