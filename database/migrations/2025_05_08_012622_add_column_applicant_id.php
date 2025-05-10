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
            $table->string('applicant_id')->nullable()->after('requested_by');
            $table->foreign('applicant_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_permission_histories', function (Blueprint $table) {
            //
        });
    }
};
