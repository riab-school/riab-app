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
        Schema::create('student_medical_check_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->longText('diagnose')->nullable();
            $table->longText('treatment')->nullable();
            $table->longText('drug_given')->nullable();
            $table->longText('note')->nullable();
            $table->longText('evidence')->nullable();

            $table->boolean('is_allow_home')->default(false)->nullable();

            $table->string('diagnozed_by')->nullable();
            $table->foreign('diagnozed_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_medical_check_histories');
    }
};
