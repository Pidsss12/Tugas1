<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'subject',
        'deadline',
        'priority',
        'status',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Model Events (Booted)
     */
    protected static function booted()
    {
        static::updated(function ($task) {
            // Jika status tugas baru saja diubah menjadi 'selesai'
            if ($task->isDirty('status') && $task->status === 'selesai') {
                // Jalankan Job otomatis untuk generate PDF
                \App\Jobs\GenerateTaskReport::dispatch($task);
            }
        });
    }

    /**
     * Check if the task is overdue (past deadline and not completed).
     */
    public function isOverdue(): bool
    {
        return $this->status !== 'selesai' && $this->deadline->isPast();
    }

    /**
     * Check if the task is due soon (within 24 hours and not completed).
     */
    public function isDueSoon(): bool
    {
        return $this->status !== 'selesai' && 
               !$this->deadline->isPast() && 
               $this->deadline->diffInHours(now()) <= 24;
    }

    /**
     * Get a human-readable Indonesian string of the remaining time or overdue duration.
     */
    public function getDueStatusAttribute(): array
    {
        if ($this->status === 'selesai') {
            return [
                'text' => 'Selesai',
                'color' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
                'bg' => 'emerald',
            ];
        }

        $now = now();

        if ($this->deadline->isPast()) {
            $diff = $this->deadline->diff($now);
            $text = 'Terlambat ';
            if ($diff->days > 0) {
                $text .= $diff->days . ' hari';
            } elseif ($diff->h > 0) {
                $text .= $diff->h . ' jam';
            } else {
                $text .= 'beberapa menit';
            }
            return [
                'text' => $text,
                'color' => 'bg-rose-500/10 text-rose-400 border border-rose-500/20 animate-pulse',
                'bg' => 'rose',
            ];
        }

        $diff = $now->diff($this->deadline);

        if ($diff->days == 0) {
            if ($diff->h == 0) {
                $text = 'Sisa ' . ($diff->i > 0 ? $diff->i : 1) . ' menit!';
            } else {
                $text = 'Sisa ' . $diff->h . ' jam';
            }
            return [
                'text' => $text,
                'color' => 'bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse',
                'bg' => 'amber',
            ];
        }

        if ($diff->days == 1) {
            return [
                'text' => 'Besok',
                'color' => 'bg-orange-500/10 text-orange-400 border border-orange-500/20',
                'bg' => 'orange',
            ];
        }

        return [
            'text' => 'Sisa ' . $diff->days . ' hari',
            'color' => 'bg-blue-500/10 text-blue-400 border border-blue-500/20',
            'bg' => 'blue',
        ];
    }
}
