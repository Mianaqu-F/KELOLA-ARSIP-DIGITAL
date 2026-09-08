<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RetentionRuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('retention_rules')->truncate();

        $kategoris = [
            'Administrasi Umum',
            'Tata Usaha',
            'Kepegawaian',
            'Keuangan',
            'Perencanaan & Anggaran',
            'Aset / BMD',
            'Hukum & Peraturan',
            'Pemerintahan',
            'Pembangunan',
            'Pengadaan Barang & Jasa',
            'Kerjasama',
            'Pengawasan / Inspektorat',
            'Statistik & Data',
            'Pelaporan',
            'Kearsipan',
        ];

        $defaults = [
            'Surat Masuk'          => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Surat Keluar'         => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Surat Edaran'         => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Surat Keputusan (SK)' => ['retention_years' => 10, 'final_action' => 'Permanen'],
            'Instruksi'            => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Nota Dinas'           => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Memorandum'           => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Undangan'             => ['retention_years' => 1,  'final_action' => 'Musnah'],
            'Berita Acara'         => ['retention_years' => 10, 'final_action' => 'Permanen'],
            'Laporan'              => ['retention_years' => 10, 'final_action' => 'Permanen'],
            'Peraturan'            => ['retention_years' => 10, 'final_action' => 'Permanen'],
            'Pengumuman'           => ['retention_years' => 3,  'final_action' => 'Musnah'],
            'Disposisi'            => ['retention_years' => 3,  'final_action' => 'Musnah'],
            'Rekomendasi'          => ['retention_years' => 5,  'final_action' => 'Musnah'],
            'Surat Tugas'          => ['retention_years' => 5,  'final_action' => 'Musnah'],
        ];

        $overrides = [
            'Kepegawaian' => [
                'Surat Keputusan (SK)' => ['retention_years' => 75, 'final_action' => 'Permanen'],
            ],
            'Aset / BMD' => [
                'Surat Keputusan (SK)' => ['retention_years' => 30, 'final_action' => 'Permanen'],
                'Berita Acara'         => ['retention_years' => 30, 'final_action' => 'Permanen'],
            ],
            'Administrasi Umum' => [
                'Surat Masuk'  => ['retention_years' => 2, 'final_action' => 'Musnah'],
                'Surat Keluar' => ['retention_years' => 2, 'final_action' => 'Musnah'],
            ],
            'Hukum & Peraturan' => [
                'Surat Edaran'         => ['retention_years' => 10, 'final_action' => 'Permanen'],
                'Instruksi'            => ['retention_years' => 10, 'final_action' => 'Permanen'],
                'Surat Keputusan (SK)' => ['retention_years' => 10, 'final_action' => 'Permanen'],
            ],
        ];

        $now = now();
        $rules = [];

        foreach ($kategoris as $kategori) {
            foreach ($defaults as $jenisDokumen => $default) {
                $rule = $overrides[$kategori][$jenisDokumen] ?? $default;

                $rules[] = [
                    'kategori'        => $kategori,
                    'jenis_dokumen'   => $jenisDokumen,
                    'retention_years' => $rule['retention_years'],
                    'final_action'    => $rule['final_action'],
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }
        }

        foreach (array_chunk($rules, 50) as $chunk) {
            DB::table('retention_rules')->insert($chunk);
        }

        $this->command?->info('✅ ' . count($rules) . ' retention rules berhasil dimasukkan.');
    }
}
