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
            if (Schema::hasColumn('psb_configs', 'buka_cetak_berkas')) {
                $table->dropColumn('buka_cetak_berkas');
            }

            if (Schema::hasColumn('psb_configs', 'tutup_cetak_berkas')) {
                $table->dropColumn('tutup_cetak_berkas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psb_configs', function (Blueprint $table) {
            if (!Schema::hasColumn('psb_configs', 'buka_cetak_berkas')) {
                $table->dateTime('buka_cetak_berkas')->nullable();
            }

            if (!Schema::hasColumn('psb_configs', 'tutup_cetak_berkas')) {
                $table->dateTime('tutup_cetak_berkas')->nullable();
            }
        });
    }
};
