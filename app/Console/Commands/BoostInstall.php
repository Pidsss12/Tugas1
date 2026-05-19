<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BoostInstall extends Command
{
    /**
     * Contoh penggunaan perintah ini:
     *   php artisan boost:install
     *   // atau panggil secara programatis
     *   \Illuminate\Support\Facades\Artisan::call('boost:install');
     */
    // Ini teks perintah yang wajib kamu jalankan
    protected $signature = 'boost:install';

    // Deskripsi singkat perintahnya
    protected $description = 'Simulasi aktivasi komponen preset frontend';

    public function handle()
    {
        $this->info('Initializing Boost installation...');
        $this->info('Syncing visual components and layout systems...');
        $this->info('Cleaning frontend views cache...');
        $this->info('Boost framework assets compiled successfully!');

        return Command::SUCCESS;
    }
}