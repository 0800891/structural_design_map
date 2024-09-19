<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslationController extends Controller
{
    /**
     * index
     *
     * @param  Request  $request
     */
    public function index(Request $request)
    {
        return view('translation');
    }

    /**
     * translation
     *
     * @param  Request  $request
     */
    public function translation(Request $request)
    {
        $request->validate([
            'sentence' => 'required',
            'target_lang' => 'required', // Validate target language selection
        ]);

        $sentence = $request->input('sentence');
        $target_lang = $request->input('target_lang');
        $api_key = env('DEEPL_KEY');

        try {
            $response = Http::get('https://api-free.deepl.com/v2/translate', [
                'auth_key' => $api_key,
                'text' => $sentence,
                'target_lang' => $target_lang, // Pass selected language to the API
            ]);

            if ($response->successful() && isset($response->json()['translations'])) {
                $translated_text = $response->json()['translations'][0]['text'];
            } else {
                $translated_text = 'Translation failed.';
            }
        } catch (\Exception $e) {
            $translated_text = 'Error: ' . $e->getMessage();
        }

        return view('translation', compact('sentence', 'translated_text', 'target_lang'));
    }
}
