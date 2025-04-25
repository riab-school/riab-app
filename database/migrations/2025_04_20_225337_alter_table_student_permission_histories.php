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
            $table->date('checked_out_at')->nullable()->after('checked_out_by');
            $table->date('checked_in_at')->nullable()->after('checked_in_by');
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
