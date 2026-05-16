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
        Schema::table('archives', function (Blueprint $table) {
            $table->string('final_action')->nullable()->after('retention_years');
        });
    }

    public function down(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->dropColumn('final_action');
        });
    }

};
