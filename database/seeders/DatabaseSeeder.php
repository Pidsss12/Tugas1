<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create test user
        User::factory()->create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@sekolah.sch.id',
        ]);

        // Seed School Tasks
        \App\Models\Task::create([
            'title' => 'Latihan Soal Integral Tentu',
            'description' => 'Kerjakan Latihan 4.2 Halaman 150 nomor 1 sampai 10 di buku latihan. Foto dan upload dalam format PDF.',
            'subject' => 'Matematika',
            'deadline' => now()->addHours(18), // Urgent: due within 24h (tomorrow)
            'priority' => 'tinggi',
            'status' => 'sedang_dikerjakan',
        ]);

        \App\Models\Task::create([
            'title' => 'Laporan Praktikum Hukum Archimedes',
            'description' => 'Susun laporan praktikum kelompok kemarin lengkap dengan pembahasan, analisis data, kesimpulan, dan dokumentasi foto.',
            'subject' => 'Fisika',
            'deadline' => now()->addDays(3), // Regular countdown (due in 3 days)
            'priority' => 'sedang',
            'status' => 'belum_mulai',
        ]);

        \App\Models\Task::create([
            'title' => 'Tugas Struktur Atom & Stoikiometri',
            'description' => 'Selesaikan lembar kerja stoikiometri reaksi kimia yang dibagikan minggu lalu.',
            'subject' => 'Kimia',
            'deadline' => now()->subDays(1)->setHour(12)->setMinute(0), // Overdue task (past deadline)
            'priority' => 'tinggi',
            'status' => 'belum_mulai',
        ]);

        \App\Models\Task::create([
            'title' => 'Short Story Translation (The Last Leaf)',
            'description' => 'Terjemahkan cerpen "The Last Leaf" karya O. Henry ke dalam Bahasa Indonesia dengan gaya bahasa narasi yang baik.',
            'subject' => 'Bahasa Inggris',
            'deadline' => now()->addDays(2), 
            'priority' => 'rendah',
            'status' => 'selesai', // Completed task
        ]);

        \App\Models\Task::create([
            'title' => 'Tugas Mandiri Proyek Aplikasi Laravel 13',
            'description' => 'Buat rancangan database dan halaman CRUD dasar untuk sistem pendaftaran siswa baru menggunakan framework Laravel 13.',
            'subject' => 'Informatika',
            'deadline' => now()->addDays(7), // Future task (due in 7 days)
            'priority' => 'tinggi',
            'status' => 'sedang_dikerjakan',
        ]);

        \App\Models\Task::create([
            'title' => 'Ringkasan Bab 4 Perang Dunia II',
            'description' => 'Buat peta konsep dan ringkasan minimal 3 halaman mengenai sebab umum dan sebab khusus terjadinya Perang Dunia II di kawasan Asia Pasifik.',
            'subject' => 'Sejarah',
            'deadline' => now()->addDays(4)->setHour(23)->setMinute(59),
            'priority' => 'sedang',
            'status' => 'belum_mulai',
        ]);
    }
}
