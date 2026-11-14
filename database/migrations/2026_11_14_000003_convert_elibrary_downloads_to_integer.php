<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('elibrary_resources')) {
            return;
        }

        foreach (DB::table('elibrary_resources')->get(['id', 'downloads']) as $row) {
            $value = (string) $row->downloads;
            preg_match('/([\d.]+)\s*([km]?)/i', $value, $match);

            $number = (float) ($match[1] ?? 0);
            $multiplier = match (strtolower($match[2] ?? '')) {
                'm' => 1000000,
                'k' => 1000,
                default => 1,
            };

            DB::table('elibrary_resources')
                ->where('id', $row->id)
                ->update(['downloads' => (int) round($number * $multiplier)]);
        }

        DB::statement('ALTER TABLE elibrary_resources MODIFY downloads INT UNSIGNED NOT NULL DEFAULT 0');
    }

    public function down(): void
    {
        if (! Schema::hasTable('elibrary_resources')) {
            return;
        }

        DB::statement("ALTER TABLE elibrary_resources MODIFY downloads VARCHAR(30) NOT NULL DEFAULT '0'");
    }
};
