<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GPTService
{
    public static function sendFeedbackToGPT($feedbackData)
    {
        $apiKey = env('OPENAI_API_KEY'); // Ensure you have your API key in the .env file
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini', // Replace with a valid OpenAI model like 'gpt-4' or 'gpt-3.5-turbo'
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Use this feedback to refine search accuracy.',
                ],
                [
                    'role' => 'user',
                    'content' => "Feedback: {$feedbackData['feedback']}, Comment: {$feedbackData['comment']}, Search Query: {$feedbackData['search_query']}",
                ],
            ]
        ]);

        return $response->json();
    }
}