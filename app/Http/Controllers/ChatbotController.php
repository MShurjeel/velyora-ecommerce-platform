<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $apiKey = env('GEMINI_API_KEY');
        // Ensure no extra 'models/' prefix is in the string
        $model = env('GEMINI_MODEL', 'gemini-3.6-flash');
        $model = str_replace('models/', '', $model);

        if (!$apiKey) {
            return response()->json([
                'status'  => 'error',
                'message' => 'API Key is missing in .env file.'
            ], 500);
        }

        // Direct Google API endpoint
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($endpoint, [
                'system_instruction' => [
                    'parts' => [
                        ['text' => 'You are a helpful customer support assistant for our e-commerce store. Answer concisely and professionally.']
                    ]
                ],
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $request->input('message')]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response generated.';

                return response()->json([
                    'status' => 'success',
                    'reply'  => $reply
                ]);
            }

            Log::error('Gemini API Error Response', [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'API returned status ' . $response->status() . ': ' . ($response->json('error.message') ?? 'Unknown error')
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Server Exception: ' . $e->getMessage()
            ], 500);
        }
    }
}