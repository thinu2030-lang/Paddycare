
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);
        $role        = auth()->user()->role ?? 'farmer';

        // Build conversation history for Gemini
        $contents = [];

        // Add system context as first user message
        $systemContext = "You are PaddyCare Assistant, an expert agricultural chatbot specializing in Sri Lankan paddy cultivation. You help " . ucfirst($role) . "s with paddy disease identification and treatment, irrigation and water management, fertilizer application schedules, weed and pest control, seed variety selection for Sri Lanka's 25 districts (Yala/Maha seasons), harvest planning and post-harvest handling, and general paddy farming best practices. Always give practical, specific advice suitable for Sri Lankan paddy farmers. Keep answers concise (3-5 sentences max). If asked about something unrelated to agriculture or paddy farming, politely redirect to paddy-related topics. Respond in the same language the user writes in (Sinhala or English).";

        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $systemContext]]
        ];
        $contents[] = [
            'role' => 'model',
            'parts' => [['text' => 'I understand. I am PaddyCare Assistant, ready to help with paddy cultivation questions.']]
        ];

        // Add conversation history
        foreach ($history as $h) {
            $contents[] = [
                'role'  => $h['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $h['content']]]
            ];
        }

        // Add current message
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        try {
            $apiKey = config('services.gemini.key');
            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => $contents,
                    'generationConfig' => [
                        'maxOutputTokens' => 400,
                        'temperature'     => 0.7,
                    ]
                ]
            );

            if ($response->successful()) {
                $data   = $response->json();
                $answer = $data['candidates'][0]['content']['parts'][0]['text']
                          ?? 'Sorry, I could not process your request.';
                return response()->json(['answer' => $answer, 'success' => true]);
            }

            return response()->json([
                'answer'  => 'Service temporarily unavailable. Please try again.',
                'success' => false
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'answer'  => 'Connection error. Please check your internet connection.',
                'success' => false
            ]);
        }
    }
}