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
        Schema::create('retention_rules', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('jenis_dokumen');
            $table->integer('retention_years')->nullable();
            $table->enum('final_action', ['musnah', 'permanen', 'serahkan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retention_rules');
    }
};
