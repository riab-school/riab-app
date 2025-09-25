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
        Schema::table('students_parent_details', function (Blueprint $table) {
            $table->enum('status_with_dad', ['biological', 'step', 'adopted'])->after('dad_is_alive')->default('biological');
            $table->enum('status_with_mom', ['biological', 'step', 'adopted'])->after('mom_is_alive')->default('biological');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_parent_details', function (Blueprint $table) {
            //
        });
    }
};
