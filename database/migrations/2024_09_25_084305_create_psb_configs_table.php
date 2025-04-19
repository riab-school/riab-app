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
        Schema::create('psb_configs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ketua_panitia');
            $table->string('tanda_tangan_ketua_panitia')->nullable();
            $table->string('kode_undangan')->unique();
            $table->year('tahun_ajaran')->unique();

            $table->string('no_rekening_psb')->nullable();
            $table->string('nama_rekening_psb')->nullable();
            $table->string('nama_bank_rekening_psb')->nullable();
            $table->integer('biaya_psb')->nullable();

            $table->integer('target_undangan')->nullable();
            $table->integer('target_reguler')->nullable();

            $table->string('nama_cp_1')->nullable();
            $table->string('nomor_cp_1')->nullable();
            $table->string('nama_cp_2')->nullable();
            $table->string('nomor_cp_2')->nullable();
            $table->string('nama_cp_3')->nullable();
            $table->string('nomor_cp_3')->nullable();

            $table->date('buka_daftar_undangan')->nullable();
            $table->date('tutup_daftar_undangan')->nullable();
            $table->date('pengumuman_administrasi_undangan')->nullable();
            $table->date('buka_tes_undangan')->nullable();
            $table->date('tutup_tes_undangan')->nullable();
            $table->date('pengumuman_undangan')->nullable();
            $table->date('buka_daftar_ulang_undangan')->nullable();
            $table->date('tutup_daftar_ulang_undangan')->nullable();

            $table->date('buka_daftar_reguler')->nullable();
            $table->date('tutup_daftar_reguler')->nullable();
            $table->date('buka_cetak_berkas')->nullable();
            $table->date('tutup_cetak_berkas')->nullable();
            $table->date('buka_tes_reguler')->nullable();
            $table->date('tutup_tes_reguler')->nullable();
            $table->date('pengumuman_reguler')->nullable();
            $table->date('buka_daftar_ulang_reguler')->nullable();
            $table->date('tutup_daftar_ulang_reguler')->nullable();

            $table->integer('jumlah_sesi_sehari')->nullable();

            $table->integer('jumlah_ruang_cat')->nullable(); 
            $table->string('prefix_ruang_cat')->default('Ruang LAB')->nullable(); 
            $table->integer('kapasitas_ruang_cat')->nullable(); // Per sesi per ruang
            
            $table->integer('jumlah_ruang_interview')->nullable();
            $table->string('prefix_ruang_interview')->default('Ruang Kelas')->nullable();
            $table->integer('kapasitas_ruang_interview')->nullable(); // Per sesi per ruang
            
            $table->integer('jumlah_ruang_interview_orangtua')->nullable();
            $table->string('prefix_ruang_interview_orangtua')->default('Ruang Kelas')->nullable();
            $table->integer('kapasitas_ruang_interview_orangtua')->nullable(); // Per sesi per ruang

            $table->string('brosur_link')->nullable();
            $table->string('booklet_link')->nullable();
            $table->string('popup_psb')->nullable();

            $table->integer('jumlah_pendaftar_undangan')->default(0);
            $table->integer('jumlah_pendaftar_undangan_lulus')->default(0);
            $table->integer('jumlah_pendaftar_undangan_tidak_lulus')->default(0);
            $table->integer('jumlah_pendaftar_undangan_pindah')->default(0);

            $table->integer('jumlah_pendaftar_reguler')->default(0);
            $table->integer('jumlah_pendaftar_reguler_lulus')->default(0);
            $table->integer('jumlah_pendaftar_reguler_tidak_lulus')->default(0);

            $table->boolean('is_active')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_configs');
    }
};
