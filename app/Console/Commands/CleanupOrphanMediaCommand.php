<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\LectureVideo;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CleanupOrphanMediaCommand extends Command
{
    protected $signature = 'lectures:cleanup-orphans {--delete : Actually delete the files and orphan records instead of dry-run} {--prune-unlinked-db : Also prune DB lecture records not referenced in any course} {--prune-stale-orders : Clean up abandoned/unpaid pending orders older than 48 hours}';

    protected $description = 'Find and clean up orphaned HLS directories, original video files, unlinked lecture records, and abandoned orders.';

    public function handle(): int
    {
        $shouldDelete = (bool) $this->option('delete');
        $pruneUnlinkedDb = (bool) $this->option('prune-unlinked-db');
        $pruneStaleOrders = (bool) $this->option('prune-stale-orders');

        $this->info($shouldDelete ? '=== RUNNING IN PURGE MODE ===' : '=== RUNNING IN DRY-RUN MODE (pass --delete to remove) ===');

        // 1. Collect all DB lecture videos
        $dbLectures = LectureVideo::all()->keyBy('id');
        $validLectureIds = $dbLectures->keys()->all();

        // 2. Collect all lecture IDs actively referenced across courses
        $courses = Course::all();
        $referencedLectureIds = [];

        foreach ($courses as $course) {
            $curriculum = is_array($course->curriculum) ? $course->curriculum : json_decode($course->curriculum ?? '[]', true);
            if (! is_array($curriculum)) {
                continue;
            }

            foreach ($curriculum as $item) {
                // 3-tier structure: Module -> Chapters -> Topics
                if (! empty($item['chapters']) && is_array($item['chapters'])) {
                    foreach ($item['chapters'] as $chapter) {
                        foreach ($chapter['topics'] ?? [] as $topic) {
                            if (! empty($topic['lectureId'])) {
                                $referencedLectureIds[] = (int) $topic['lectureId'];
                            }
                        }
                    }
                }
                // Legacy 2-tier structure: Chapter -> Topics
                if (! empty($item['topics']) && is_array($item['topics'])) {
                    foreach ($item['topics'] as $topic) {
                        if (! empty($topic['lectureId'])) {
                            $referencedLectureIds[] = (int) $topic['lectureId'];
                        }
                    }
                }
            }
        }
        $referencedLectureIds = array_unique(array_filter($referencedLectureIds));

        $this->line("Found <comment>" . count($validLectureIds) . "</comment> total DB lecture records.");
        $this->line("Found <comment>" . count($referencedLectureIds) . "</comment> lecture IDs referenced in course curricula: " . implode(', ', $referencedLectureIds));

        // 3. Scan HLS directories
        $hlsBasePath = storage_path('app/lectures/hls');
        $orphanHlsDirs = [];

        if (File::exists($hlsBasePath)) {
            $subDirs = File::directories($hlsBasePath);
            foreach ($subDirs as $dir) {
                $basename = basename($dir);
                if (is_numeric($basename)) {
                    $id = (int) $basename;
                    if (! in_array($id, $validLectureIds, true)) {
                        $orphanHlsDirs[] = $dir;
                    }
                }
            }
        }

        $this->newLine();
        $this->info("=== Orphan HLS Directories (" . count($orphanHlsDirs) . ") ===");
        foreach ($orphanHlsDirs as $dir) {
            $this->warn(" - Orphan dir: " . $dir);
            if ($shouldDelete) {
                File::deleteDirectory($dir);
                $this->line("   <fg=green>Deleted directory.</>");
            }
        }

        // 4. Scan original video files
        $originalsBasePath = storage_path('app/lectures/originals');
        $orphanOriginals = [];
        $activeOriginalPaths = $dbLectures->pluck('file_path')->filter()->map(fn ($p) => basename($p))->all();

        if (File::exists($originalsBasePath)) {
            $files = File::files($originalsBasePath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                if (! in_array($filename, $activeOriginalPaths, true)) {
                    $orphanOriginals[] = $file->getRealPath();
                }
            }
        }

        $this->newLine();
        $this->info("=== Orphan Original Video Files (" . count($orphanOriginals) . ") ===");
        foreach ($orphanOriginals as $filePath) {
            $this->warn(" - Orphan file: " . $filePath);
            if ($shouldDelete) {
                File::delete($filePath);
                $this->line("   <fg=green>Deleted file.</>");
            }
        }

        // 5. Unreferenced DB lecture records (if requested)
        $unlinkedDbRecords = $dbLectures->filter(fn ($rec) => ! in_array($rec->id, $referencedLectureIds, true));

        $this->newLine();
        $this->info("=== Unreferenced DB Lecture Records (" . $unlinkedDbRecords->count() . ") ===");
        $disk = Storage::disk(LectureVideo::diskName());

        foreach ($unlinkedDbRecords as $unlinked) {
            $this->line(" - Lecture #{$unlinked->id}: '{$unlinked->title}' (status: {$unlinked->status}, course_id: {$unlinked->course_id})");
            if ($shouldDelete && $pruneUnlinkedDb) {
                // Delete associated HLS if exists
                $hlsDir = $unlinked->hls_path ?: ('hls/' . $unlinked->id);
                if ($disk->exists($hlsDir)) {
                    $disk->deleteDirectory($hlsDir);
                }
                if ($unlinked->original_path && $disk->exists($unlinked->original_path)) {
                    $disk->delete($unlinked->original_path);
                }
                $logFile = storage_path('logs/lecture-' . $unlinked->id . '.log');
                if (is_file($logFile)) {
                    @unlink($logFile);
                }
                $unlinked->progressRecords()->delete();
                $unlinked->delete();
                $this->line("   <fg=green>Pruned DB record and associated files.</>");
            }
        }

        // 6. Stale abandoned orders (if requested)
        if ($pruneStaleOrders) {
            $staleOrders = Order::where('status', Order::STATUS_PENDING)
                ->where('created_at', '<', now()->subHours(48))
                ->get();

            $this->newLine();
            $this->info("=== Stale Pending Orders Older than 48 Hours (" . $staleOrders->count() . ") ===");
            foreach ($staleOrders as $order) {
                $this->line(" - Order #{$order->id}: {$order->reference} (Amount: {$order->amountLabel()}, created: {$order->created_at->toDateTimeString()})");
                if ($shouldDelete) {
                    $order->update(['status' => Order::STATUS_CANCELLED, 'failure_reason' => 'Auto-cancelled due to inactivity (48h timeout)']);
                    $this->line("   <fg=green>Marked order as cancelled.</>");
                }
            }
        }

        $this->newLine();
        $this->info("Cleanup scan complete.");

        return self::SUCCESS;
    }
}
