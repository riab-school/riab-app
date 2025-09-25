<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use App\Models\User;
use App\Models\PsbConfig;

class CleanOrphanS3 extends Command
{
    protected $signature = 's3:clean-orphan {prefix=student} {--dry-run} {--force}';
    protected $description = 'Delete orphan folders in S3 (student/staff → users, psb → psb_configs)';

    public function handle()
    {
        $prefix = $this->argument('prefix'); // student / staff / psb
        $dryRun = $this->option('dry-run');
        $force  = $this->option('force');

        $this->info("Scanning S3 prefix: {$prefix}");

        // ambil semua folder di prefix
        $folders = Storage::disk('s3')->directories($prefix);

        $orphanFolders = [];

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
                $orphanFolders[] = $folder;
            }
        }

        // hasil scan
        if (empty($orphanFolders)) {
            $this->info("No orphan folders found.");
            return Command::SUCCESS;
        }

        $this->warn("Found " . count($orphanFolders) . " orphan folders:");
        foreach ($orphanFolders as $f) {
            $this->line(" - {$f}");
        }

        // opsi dry-run → hanya tampil
        if ($dryRun) {
            $this->info("Dry run → no folders deleted.");
            return Command::SUCCESS;
        }

        // opsi force → langsung hapus semua
        if ($force) {
            foreach ($orphanFolders as $f) {
                Storage::disk('s3')->deleteDirectory($f);
                $this->info("Deleted: {$f}");
            }
            $this->info("All orphan folders deleted (forced).");
            return Command::SUCCESS;
        }

        // default → konfirmasi sekali untuk semua
        if ($this->confirm("Delete ALL these " . count($orphanFolders) . " folders?")) {
            foreach ($orphanFolders as $f) {
                Storage::disk('s3')->deleteDirectory($f);
                $this->info("Deleted: {$f}");
            }
            $this->info("Cleanup finished.");
        } else {
            $this->info("Aborted. No folders deleted.");
        }

        return Command::SUCCESS;
    }
}
