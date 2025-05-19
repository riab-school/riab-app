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
        Schema::table('master_classrooms', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')->constrained('master_tahun_ajarans')->onUpdate('cascade')->onDelete('cascade')->nullable()->after('location');
        });

        Schema::table('master_dormitories', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')->constrained('master_tahun_ajarans')->onUpdate('cascade')->onDelete('cascade')->nullable()->after('head_id');
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
