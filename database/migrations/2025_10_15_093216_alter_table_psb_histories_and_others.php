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
        Schema::table('psb_histories', function (Blueprint $table) {
            $table->dropColumn('exam_date');
        });
        Schema::table('psb_cat_rooms', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->uuid('id')->primary()->first();
        });
        Schema::table('psb_interview_rooms', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->uuid('id')->primary()->first();
        });
        Schema::table('psb_parent_interview_rooms', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->uuid('id')->primary()->first();
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
