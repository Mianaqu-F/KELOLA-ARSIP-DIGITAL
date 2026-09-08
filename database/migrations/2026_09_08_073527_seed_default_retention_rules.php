<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('retention_rules')->count() === 0) {
            app(\Database\Seeders\RetentionRuleSeeder::class)->run();
        }
    }

    public function down(): void
    {
        DB::table('retention_rules')->truncate();
    }
};
