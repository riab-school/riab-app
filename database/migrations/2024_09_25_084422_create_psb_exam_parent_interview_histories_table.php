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
        Schema::create('psb_exam_parent_interview_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_configs_id');
            $table->foreign('psb_configs_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->longText('q1');
            $table->longText('q2');
            $table->longText('q3');
            $table->longText('q4');
            $table->longText('q5');
            $table->longText('q6');
            $table->longText('q7');
            $table->longText('q8');
            $table->longText('q9');
            $table->longText('q10');
            $table->longText('q11');
            $table->longText('q12');
            $table->longText('q13');
            $table->longText('q14');
            $table->longText('q15');
            $table->longText('q16');
            $table->longText('q17');
            $table->longText('q18');
            $table->longText('q19');
            $table->longText('q20');
            $table->longText('q21');
            $table->longText('q22');
            $table->longText('q23');
            $table->longText('q24');
            $table->longText('q25');
            $table->longText('q26');
            $table->longText('q27');
            $table->longText('q28');
            $table->longText('q29');
            $table->longText('q30');
            $table->longText('q31');

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
        Schema::dropIfExists('psb_exam_parent_interview_histories');
    }
};
