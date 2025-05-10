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
        Schema::table('student_permission_histories', function (Blueprint $table) {
            $table->boolean('is_notify_parent')->after('to_date');
        });

        Schema::table('students_achievements', function (Blueprint $table) {
            $table->boolean('is_notify_parent')->after('process_by');
        });

        Schema::table('students_violations', function (Blueprint $table) {
            $table->boolean('is_notify_parent')->after('process_by');
        });

        Schema::table('student_medical_check_histories', function (Blueprint $table) {
            $table->boolean('is_notify_parent')->after('diagnozed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
