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
        Schema::table('students_memorizations', function (Blueprint $table) {
            $table->boolean('is_notify_parent')->default(0)->after('process_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_memorizations', function (Blueprint $table) {
            //
        });
    }
};
