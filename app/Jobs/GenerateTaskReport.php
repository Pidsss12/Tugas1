<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateTaskReport implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new job instance.
     */
    public function __construct($task = null)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Log::info('Queue: Memulai proses generate laporan tugas...');

        if ($this->task) {
            // Karena kita tidak bisa menginstal library PDF (storage disk penuh),
            // kita simulasikan pembuatan "Sertifikat/Laporan PDF" menggunakan HTML file.
            $reportName = 'laporan_tugas_' . $this->task->id . '.html';
            $reportPath = public_path('reports');
            
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0777, true);
            }

            $htmlContent = "
            <html>
                <head><title>Sertifikat Tugas Selesai</title></head>
                <body style='font-family: Arial, sans-serif; text-align: center; padding: 50px;'>
                    <h1 style='color: #4f46e5;'>SERTIFIKAT PENYELESAIAN TUGAS</h1>
                    <h2>Tugas: {$this->task->title}</h2>
                    <p>Mata Pelajaran: {$this->task->subject}</p>
                    <p>Status: SELESAI</p>
                    <p>Tanggal Diselesaikan: " . now()->format('d M Y H:i') . "</p>
                    <hr>
                    <p><i>Laporan ini di-generate otomatis oleh sistem (Simulasi PDF via HTML).</i></p>
                </body>
            </html>
            ";

            file_put_contents($reportPath . '/' . $reportName, $htmlContent);
            \Illuminate\Support\Facades\Log::info("Queue: Laporan tugas {$this->task->id} berhasil di-generate.");
        } else {
            sleep(3);
            
            $reportName = 'laporan_tugas_global.html';
            $reportPath = public_path('reports');
            
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0777, true);
            }

            $tasks = \App\Models\Task::all();
            $tasksHtml = '';
            foreach ($tasks as $t) {
                $statusColor = $t->status === 'selesai' ? '#10b981' : ($t->status === 'sedang_dikerjakan' ? '#f59e0b' : '#6b7280');
                $statusText = $t->status === 'selesai' ? 'Selesai' : ($t->status === 'sedang_dikerjakan' ? 'Sedang Dikerjakan' : 'Belum Mulai');
                $priorityColor = $t->priority === 'tinggi' ? '#ef4444' : ($t->priority === 'sedang' ? '#f59e0b' : '#3b82f6');
                
                $tasksHtml .= "
                <tr style='border-bottom: 1px solid #1e293b;'>
                    <td style='padding: 14px 10px; text-align: left; color: #e2e8f0; font-size: 13px;'>{$t->title}</td>
                    <td style='padding: 14px 10px; text-align: left; color: #94a3b8; font-size: 13px;'>{$t->subject}</td>
                    <td style='padding: 14px 10px; text-align: left; font-size: 13px;'>
                        <span style='color: {$statusColor}; font-weight: 600; padding: 4px 8px; background: {$statusColor}15; border: 1px solid {$statusColor}30; border-radius: 6px;'>{$statusText}</span>
                    </td>
                    <td style='padding: 14px 10px; text-align: left; font-size: 13px;'>
                        <span style='color: {$priorityColor}; font-weight: 600;'>" . ucfirst($t->priority) . "</span>
                    </td>
                    <td style='padding: 14px 10px; text-align: left; color: #cbd5e1; font-size: 13px;'>" . $t->deadline->format('d M Y - H:i') . " WIB</td>
                </tr>";
            }

            $htmlContent = "
            <html>
                <head>
                    <title>Laporan Tugas Sekolah (Global)</title>
                    <style>
                        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; padding: 50px; background-color: #080c14; color: #cbd5e1; }
                        .container { max-width: 900px; margin: 0 auto; background: #0c1322; border: 1px solid #1e293b; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
                        h1 { color: #818cf8; text-align: center; margin-bottom: 5px; font-size: 24px; font-weight: 800; }
                        .subtitle { text-align: center; color: #64748b; font-size: 13px; margin-bottom: 30px; font-weight: 500; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th { background-color: #0d1527; padding: 12px 10px; text-align: left; border-bottom: 2px solid #1e293b; color: #94a3b8; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; }
                        hr { border: 0; border-top: 1px solid #1e293b; margin: 20px 0; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>LAPORAN PERKEMBANGAN TUGAS SEKOLAH</h1>
                        <p class='subtitle'>Dicetak otomatis pada: " . now()->format('d M Y - H:i') . " WIB</p>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>Judul Tugas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$tasksHtml}
                            </tbody>
                        </table>
                    </div>
                </body>
            </html>
            ";

            file_put_contents($reportPath . '/' . $reportName, $htmlContent);
            \Illuminate\Support\Facades\Log::info('Queue: Laporan tugas (Global) berhasil di-generate.');
        }
    }
}
