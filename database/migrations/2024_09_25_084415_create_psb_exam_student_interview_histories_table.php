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
        Schema::create('psb_exam_student_interview_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_configs_id');
            $table->foreign('psb_configs_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->longText('prestasi_akademik');
            $table->longText('prestasi_non_akademik');
            $table->string('bahasa_inggris');
            $table->string('bahasa_arab');
            $table->longText('info_masuk');
            $table->longText('alasan_masuk');
            $table->longText('riwayat_penyakit');
            $table->string('merokok');
            $table->string('pacaran');
            $table->longText('penggunaan_hp');
            $table->longText('pelanggaran');
            $table->longText('guru_tidak_suka');
            $table->longText('pelajaran_suka');
            $table->longText('pelajaran_tidak_suka');
            $table->longText('cita_cita');
            $table->longText('alasan_memilih_jurusan');
            $table->longText('hubungan_ortu');
            $table->string('rekomendasi_interview');
            $table->longText('keterangan_interview');

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
        Schema::dropIfExists('psb_exam_student_interview_histories');
    }
};
