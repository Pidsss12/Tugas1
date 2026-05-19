<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    /**
     * 1. AI Chat Assistant
     * Mensimulasikan AI Chatbot yang membantu user mengelola tugas mereka.
     */
    public function chatAssistant(Request $request)
    {
        $userMessage = $request->input('message', 'Halo!');

        // Simulasi logika AI membalas pesan user
        $aiResponse = "Halo! Saya adalah AI Task Assistant. Berdasarkan jadwal Anda hari ini, ada 2 tugas mendesak untuk Matematika dan Fisika. Apakah Anda butuh tips belajar untuk keduanya?";

        return response()->json([
            'success' => true,
            'feature' => 'AI Chat Assistant',
            'data' => [
                'user_message' => $userMessage,
                'ai_response'  => $aiResponse,
            ]
        ], 200);
    }

    /**
     * 2. AI FAQ Generator
     * Mensimulasikan pembuatan FAQ otomatis menggunakan AI berdasarkan materi pelajaran yang sedang dibahas.
     */
    public function generateFaq(Request $request)
    {
        $topic = $request->input('topic', 'Sejarah Kemerdekaan');

        // Simulasi AI men-generate list FAQ dari sebuah topik
        $faqs = [
            [
                'question' => "Apa poin utama dari $topic?",
                'answer'   => "Poin utamanya adalah deklarasi kedaulatan dan momen proklamasi yang menandai lahirnya negara baru."
            ],
            [
                'question' => "Kapan peristiwa terkait $topic ini terjadi?",
                'answer'   => "Berdasarkan konteks sejarah, peristiwa ini bermula pada awal hingga pertengahan abad ke-20."
            ]
        ];

        return response()->json([
            'success' => true,
            'feature' => 'AI FAQ Generator',
            'data' => [
                'topic' => $topic,
                'faqs'  => $faqs,
            ]
        ], 200);
    }

    /**
     * AI Web Chat Handler
     * Digunakan oleh antarmuka web (Blade)
     */
    public function webChat(Request $request)
    {
        $userMessage = $request->input('message');
        
        // Simulasi balasan cerdas AI
        $responses = [
            "Tentu! Berdasarkan prioritas, selesaikan dulu tugas dengan label 'Tinggi' dan deadline besok.",
            "Saya sarankan Anda membuat jadwal belajar 45 menit fokus, lalu 15 menit istirahat untuk tugas Matematika.",
            "Tugas Kimia tentang Stoikiometri cukup rumit. Apakah Anda ingin saya ringkaskan rumus-rumus kuncinya?",
            "Baik. Jika ada kesulitan saat memahami Sejarah Kemerdekaan, saya siap membuatkan peta konsep (mind map) untuk Anda."
        ];
        
        $aiReply = $responses[array_rand($responses)];
        
        if (empty(trim($userMessage))) {
            $aiReply = "Halo! Ada yang bisa saya bantu terkait tugas sekolah Anda hari ini?";
        }

        return redirect()->back()->with('ai_reply', $aiReply)->with('ai_user_message', $userMessage);
    }
}
