<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('archive_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nama');
            $table->string('email');
            $table->string('instansi')->nullable();
            $table->text('alasan');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->foreignId('approved_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->string('access_token')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_requests');
    }
};
