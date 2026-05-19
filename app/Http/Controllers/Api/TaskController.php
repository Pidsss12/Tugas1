<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Endpoint 1: Mendapatkan semua data tugas
     */
    public function index()
    {
        $tasks = Task::all();

        // Bonus #1: Menggunakan JSON:API Standards via Laravel Resources
        return response()->json([
            'success' => true,
            'message' => 'Data tugas berhasil diambil',
            'data'    => \App\Http\Resources\TaskResource::collection($tasks)
        ], 200);
    }

    /**
     * Bonus #2: Simulasi Semantic / Vector Search
     */
    public function searchSimulations(Request $request)
    {
        // Contoh implementasi di mana ->whereVectorSimilarTo('deskripsi', $queryVektor) digunakan
        // (Membutuhkan DB PostgreSQL + pgvector, di sini sekadar kerangka kerja/konsep)
        
        // $tasks = Task::query()
        //     ->whereVectorSimilarTo('embedding', [0.1, -0.2, 0.3]) // vektor pencarian
        //     ->get();

        return response()->json(['message' => 'Simulasi Semantic Search berhasil']);
    }

    /**
     * Bonus #3: Simulasi Laravel AI SDK
     */
    public function askAi()
    {
        // Contoh penggunaan ekstensi ekosistem modern Laravel\Ai (pseudo-code)
        // $response = \Laravel\Ai\Facades\Ai::ask('Bantu saya membuat ringkasan untuk tugas-tugas ini...');

        return response()->json(['message' => 'Simulasi interaksi AI SDK berhasil (Misal: ChatGPT meringkas tugas)']);
    }

    /**
     * Bonus #4 & #5: Inertia v3 dan Passkeys (Konsep UI)
     * - Inertia v3 digunakan di sisi Frontend (misal resources/js/Pages) dengan `useHttp` dan instant visits.
     * - Passkeys (Passwordless) biasanya menggunakan package seperti `web-authn` atau bawaan spesifik,
     *   yang memverifikasi sidik jari/FaceID tanpa password.
     */

    /**
     * Endpoint 2: Mendapatkan detail satu tugas berdasarkan ID
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Data tugas tidak ditemukan',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data detail tugas berhasil diambil',
            'data'    => $task
        ], 200);
    }

    /**
     * Endpoint 3: Menambahkan data tugas baru
     */
    #[\Illuminate\Routing\Attributes\Controllers\Middleware('auth:sanctum')]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'subject'     => 'required|string|max:100',
            'deadline'    => 'required|date',
            'priority'    => 'required|in:rendah,sedang,tinggi',
            'status'      => 'required|in:belum_mulai,sedang_dikerjakan,selesai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data'    => $validator->errors()
            ], 422);
        }

        $task = Task::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tugas baru berhasil ditambahkan',
            'data'    => $task
        ], 201);
    }
}

