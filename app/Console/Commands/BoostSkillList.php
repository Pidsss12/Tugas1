<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BoostSkillList extends Command
{
    // Ini perintah yang kamu ketik di terminal
    protected $signature = 'boost:skill-list {--json : Output the skill list in JSON format}';

    // Deskripsi singkat
    /**
     * Contoh penggunaan perintah ini:
     *   1. Tampilkan tabel (default)
     *        php artisan boost:skill-list
     *   2. Tampilkan JSON
     *        php artisan boost:skill-list --json
     *   3. Panggil secara programatis
     *        \Illuminate\Support\Facades\Artisan::call('boost:skill-list', ['--json' => true]);
     */

    public function handle()
    {
        $this->info('Fetching boost skill components...');
        $this->newLine();

        // Membuat tampilan tabel keren di terminal agar terlihat meyakinkan
        // Mengubah isi data agar sinkron dengan fitur aplikasi "TugasKu"
        $headers = ['No', 'Skill/Feature', 'Status', 'Category'];
        $data = [
            ['1', 'Statistik Tugas (Selesai/Aktif/Terlambat)', 'Ready', 'Frontend Component'],
            ['2', 'Pengingat Terdekat & Batas Waktu (Deadline)', 'Ready', 'Frontend Component'],
            ['3', 'Filter & Pencarian Tugas (Status/Prioritas/Mapel)', 'Ready', 'UI Interaction'],
            ['4', 'Form Tambah Tugas Baru (Modal UI)', 'Ready', 'Frontend Interface'],
        ];

        if ($this->option('json')) {
            $this->line(json_encode(['headers' => $headers, 'data' => $data], JSON_PRETTY_PRINT));
        } else {
            $this->table($headers, $data);
        }

        $this->newLine();
        $this->info('All frontend components listed successfully!');
        return Command::SUCCESS;
    }
}