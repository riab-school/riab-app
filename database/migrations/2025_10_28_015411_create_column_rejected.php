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
        Schema::table('student_details', function (Blueprint $table) {
            $table->boolean('is_rejected')->nullable()->after('is_biological');
            $table->text('rejection_reason')->nullable()->after('is_rejected');
        });
        Schema::table('students_origin_schools', function (Blueprint $table) {
            $table->boolean('is_rejected')->nullable()->after('origin_school_graduate');
            $table->text('rejection_reason')->nullable()->after('is_rejected');
        });
        Schema::table('students_parent_details', function (Blueprint $table) {
            $table->boolean('is_rejected')->nullable()->after('marital_status');
            $table->text('rejection_reason')->nullable()->after('is_rejected');
        });
        Schema::table('students_guardian_details', function (Blueprint $table) {
            $table->boolean('is_rejected')->nullable()->after('relation_detail');
            $table->text('rejection_reason')->nullable()->after('is_rejected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_details', function (Blueprint $table) {
            $table->dropIfExists('is_rejected');
            $table->dropIfExists('rejection_reason');
        });
        Schema::table('students_origin_schools', function (Blueprint $table) {
            $table->dropIfExists('is_rejected');
            $table->dropIfExists('rejection_reason');
        });
        Schema::table('students_parent_details', function (Blueprint $table) {
            $table->dropIfExists('is_rejected');
            $table->dropIfExists('rejection_reason');
        });
        Schema::table('students_guardian_details', function (Blueprint $table) {
            $table->dropIfExists('is_rejected');
            $table->dropIfExists('rejection_reason');
        });
    }
};
