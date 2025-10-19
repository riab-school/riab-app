<?php

namespace Database\Seeders\Test\Scenario;

use Illuminate\Database\Seeder;
use App\Models\PsbHistory;
use Illuminate\Support\Facades\DB;

class StudentInvitedGetExamNumber extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $this->command->info('⏳ Memberikan nomor ujian untuk jalur undangan yang sudah valid...');

        // Ambil semua peserta undangan aktif
        $students = PsbHistory::where('registration_method', 'invited')
            ->where('is_paid', true)
            ->where('is_administration_confirmed', true)
            ->orderBy('created_at', 'asc')
            ->get();

        $total = $students->count();
        $this->command->info("📋 Ditemukan {$total} peserta invited yang eligible.");

        $processed = 0;

        foreach ($students as $student) {
            DB::transaction(function () use ($student, &$processed) {
                // Skip jika sudah punya nomor ujian
                if ($student->exam_number) {
                    return;
                }

                // Generate nomor ujian pakai helper getCounter()
                $examNumber = getCounter($student->user_id);

                if ($examNumber) {
                    $student->update([
                        'exam_number' => $examNumber,
                    ]);
                    $processed++;
                }
            });
        }

        $this->command->info("✅ {$processed} peserta berhasil diberikan nomor ujian.");
        $this->command->info("Selesai.");
    }
}
