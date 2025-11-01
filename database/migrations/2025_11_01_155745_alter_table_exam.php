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
        Schema::table('psb_exam_pray_histories', function (Blueprint $table) {
            $table->string('point')->nullable()->after('keterangan_ibadah');
        });
        Schema::table('psb_exam_student_interview_histories', function (Blueprint $table) {
            $table->string('point')->nullable()->after('keterangan_interview');
        });
        Schema::table('psb_exam_alquran_histories', function (Blueprint $table) {
            $table->string('point')->nullable()->after('keterangan_hafalan');
            $table->string('point_hafalan')->nullable()->after('point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psb_exam_pray_histories', function (Blueprint $table) {
            //
        });
    }
};
