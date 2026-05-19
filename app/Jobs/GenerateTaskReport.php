<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateTaskReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Log::info('Queue: Memulai proses generate laporan tugas...');

        // Simulasi proses yang memakan waktu (misalnya query ribuan data, render PDF, dsb)
        sleep(3); 

        \Illuminate\Support\Facades\Log::info('Queue: Laporan tugas berhasil di-generate secara background!');
    }
}
