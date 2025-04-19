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
        Schema::create('parent_claim_students', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('parent_user_id')->unique();
            $table->foreign('parent_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('student_user_id');
            $table->foreign('student_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_claim_students');
    }
};
