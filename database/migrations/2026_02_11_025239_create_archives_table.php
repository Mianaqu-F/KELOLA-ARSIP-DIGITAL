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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_surat');
            $table->string('jenis_dokumen');
            $table->string('sifat_surat');

            $table->string('kategori');
            $table->string('opd');
            $table->year('tahun');

            $table->string('file');
            $table->integer('file_size')->nullable();
            $table->string('file_type')->nullable();

            $table->text('deskripsi')->nullable();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->integer('retention_years')->nullable();
            $table->date('retention_end_date')->nullable();
            $table->enum('retention_status', ['aktif', 'inaktif', 'permanen'])->default('aktif');

            $table->timestamps();
            $table->softDeletes();
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
