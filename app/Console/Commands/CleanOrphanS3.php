<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use App\Models\User;
use App\Models\PsbConfig;

class CleanOrphanS3 extends Command
{
    protected $signature = 's3:clean-orphan {prefix=student} {--dry-run}';
    protected $description = 'Delete orphan user folders in S3 (student/staff/users or psb/psb_configs)';

    public function handle()
    {
        $prefix = $this->argument('prefix'); // student / staff / psb
        $dryRun = $this->option('dry-run');

        $this->info("Scanning S3 prefix: {$prefix}");

        // ambil daftar folder di prefix
        $folders = Storage::disk('s3')->directories($prefix);

        foreach ($folders as $folder) {
            // contoh: "student/123_docs"
            $parts = explode('/', $folder);
            if (count($parts) < 2) {
                continue;
            }

            $userFolder = $parts[1]; // misal "123_docs"

            // ambil angka di depan sebelum underscore
            preg_match('/^(\d+)/', $userFolder, $matches);
            $id = $matches[1] ?? null;

            if (!$id) {
                $this->warn("Skip folder: {$folder} (ID not detected)");
                continue;
            }

            // tentukan model/table sesuai prefix
            $exists = false;
            if (in_array($prefix, ['student', 'staff'])) {
                $exists = User::where('id', $id)->exists();
            } elseif ($prefix === 'psb') {
                $exists = PsbConfig::where('id', $id)->exists();
            }

            if (!$exists) {
                $this->warn("Orphan folder found: {$folder}");

                if ($dryRun) {
                    $this->line("Dry run → would delete {$folder}");
                } elseif ($this->confirm("Delete ALL files in {$folder}?")) {
                    Storage::disk('s3')->deleteDirectory($folder);
                    $this->info("Deleted: {$folder}");
                }
            }
        }

        $this->info("Scan finished for prefix: {$prefix}");
        return Command::SUCCESS;
    }
}
