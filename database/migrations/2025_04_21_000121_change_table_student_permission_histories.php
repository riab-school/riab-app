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
            $table->dropForeign(['requested_by']); // Jika sebelumnya foreign key
            $table->dropColumn('requested_by');
        });

        Schema::table('student_permission_histories', function (Blueprint $table) {
            // Tambahkan kolom enum baru
            $table->enum('requested_by', ['orang_tua', 'wali', 'siswa', 'staff_kesehatan'])->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_permission_histories', function (Blueprint $table) {
            // Drop enum kolom
            $table->dropColumn('requested_by');
        });

        Schema::table('student_permission_histories', function (Blueprint $table) {
            // Tambahkan kembali kolom string
            $table->string('requested_by')->nullable(); // atau tambahkan foreign key jika perlu
        });
    }
};
