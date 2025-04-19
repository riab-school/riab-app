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
        Schema::create('psb_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_config_id');
            $table->foreign('psb_config_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->string('registration_number')->unique()->nullable();
            $table->enum('registration_method', ['invited', 'reguler'])->default('invited');

            $table->boolean('is_paid')->nullable()->default(false);

            $table->enum('class_focus', ['mipa', 'mak'])->nullable()->default(NULL);

            $table->boolean('is_administration_confirmed')->nullable();
            $table->boolean('is_administration_pass')->nullable();
            $table->longText('administration_summary')->nullable();

            $table->boolean('is_allow_change_exam_date')->nullable();

            $table->boolean('is_exam_offline')->nullable();
            $table->longText('link')->nullable();

            $table->string('exam_number')->unique()->nullable();

            $table->boolean('is_cat_exam_completed')->nullable();
            $table->boolean('is_interview_session_completed')->nullable();
            $table->boolean('is_parent_interview_session_completed')->nullable();

            $table->boolean('is_exam_pass')->nullable();
            $table->longText('exam_summary')->nullable();
        
            $table->boolean('is_moved_to_non_invited')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_histories');
    }
};
