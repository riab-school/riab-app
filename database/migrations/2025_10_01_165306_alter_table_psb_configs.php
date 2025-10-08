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
        Schema::table('psb_configs', function (Blueprint $table) {
            $table->date('buka_verifikasi_berkas_undangan')->nullable()->after('tutup_daftar_undangan');
            $table->date('tutup_verifikasi_berkas_undangan')->nullable()->after('buka_verifikasi_berkas_undangan');

            $table->date('buka_verifikasi_berkas_reguler')->nullable()->after('tutup_daftar_reguler');
            $table->date('tutup_verifikasi_berkas_reguler')->nullable()->after('buka_verifikasi_berkas_reguler');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psb_configs', function (Blueprint $table) {
            //
        });
    }
};
