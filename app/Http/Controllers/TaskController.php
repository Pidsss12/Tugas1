<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with search, filter, sorting, and dashboard stats.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // 1. Search Query
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // 2. Filters
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && $request->priority !== 'semua') {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('subject') && $request->subject !== 'semua') {
            $query->where('subject', $request->subject);
        }

        // 3. Sorting
        $sortBy = $request->get('sort', 'deadline_dekat');
        if ($sortBy === 'deadline_dekat') {
            $query->orderBy('deadline', 'asc');
        } elseif ($sortBy === 'deadline_lama') {
            $query->orderBy('deadline', 'desc');
        } elseif ($sortBy === 'prioritas_tinggi') {
            $query->orderByRaw("CASE priority WHEN 'tinggi' THEN 1 WHEN 'sedang' THEN 2 WHEN 'rendah' THEN 3 END");
        } elseif ($sortBy === 'terbaru') {
            $query->orderBy('created_at', 'desc');
        }

        $tasks = $query->get();

        // Calculate Stats
        $stats = [
            'total' => Task::count(),
            'belum_mulai' => Task::where('status', 'belum_mulai')->count(),
            'sedang_dikerjakan' => Task::where('status', 'sedang_dikerjakan')->count(),
            'selesai' => Task::where('status', 'selesai')->count(),
            'mendesak' => Task::where('status', '!=', 'selesai')
                ->where('deadline', '<=', now()->addHours(24))
                ->where('deadline', '>=', now())
                ->count(),
            'terlambat' => Task::where('status', '!=', 'selesai')
                ->where('deadline', '<', now())
                ->count(),
        ];

        // Get unique subjects for filter dropdown
        $subjects = Task::pluck('subject')->unique()->filter()->values()->toArray();
        if (empty($subjects)) {
            $subjects = ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa Indonesia', 'Bahasa Inggris', 'Informatika', 'Sejarah'];
        }

        // Get upcoming urgent tasks (deadline < 48 hours, not completed) for the reminder sidebar
        $reminders = Task::where('status', '!=', 'selesai')
            ->where('deadline', '>=', now())
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact('tasks', 'stats', 'subjects', 'reminders'));
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'deadline' => 'required|date',
            'priority' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:belum_mulai,sedang_dikerjakan,selesai',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'deadline' => 'required|date',
            'priority' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:belum_mulai,sedang_dikerjakan,selesai',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Quick action to toggle/cycle task status.
     */
    public function updateStatus(Task $task)
    {
        $nextStatus = [
            'belum_mulai' => 'sedang_dikerjakan',
            'sedang_dikerjakan' => 'selesai',
            'selesai' => 'belum_mulai',
        ];

        $newStatus = $nextStatus[$task->status] ?? 'belum_mulai';
        $task->update(['status' => $newStatus]);

        $statusLabels = [
            'belum_mulai' => 'Belum Mulai',
            'sedang_dikerjakan' => 'Sedang Dikerjakan',
            'selesai' => 'Selesai',
        ];

        return redirect()->route('tasks.index')->with('success', "Status tugas diubah menjadi: {$statusLabels[$newStatus]}!");
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Download PDF Report Simulation
     */
    public function downloadReport()
    { 
        // Fitur Wajib #5: Queue Simulation
        // Memanggil job untuk digenerate di background
        \App\Jobs\GenerateTaskReport::dispatch();

        return redirect()->route('tasks.index')->with('success', 'Permintaan download PDF laporan sedang diproses di background (Antrean Queue). File akan segera dikirim ke email atau tersedia di notifikasi Anda!');
    }

    /**
     * Show/Download certificate for a specific completed task.
     */
    public function showCertificate(Task $task)
    { 
        if ($task->status !== 'selesai') {
            abort(404, 'Tugas belum selesai.');
        }

        $reportName = 'laporan_tugas_' . $task->id . '.html';
        $reportPath = public_path('reports');
        $fullPath = $reportPath . '/' . $reportName;

        if (!file_exists($fullPath)) {
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0777, true);
            }
            // Generate on the fly
            \App\Jobs\GenerateTaskReport::dispatchSync($task);
        }

        return response()->file($fullPath, [
            'Content-Type' => 'text/html',
        ]);
    }
}
