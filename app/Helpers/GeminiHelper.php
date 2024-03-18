<?php

namespace App\Helpers;

use App\Models\GeminiChat;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Resources\ChatSession;

class GeminiHelper
{
    private static string $apiKey;
    private ChatSession $chat;
    public function __construct()
    {
        self::$apiKey = config('services.gemini.key');
    }

    public function textGenerate()
    {
        $request = request();
        $gemini = new \App\Gemini\Gemini($request->chat_session);
        if (!$request->chat_session) {
            $chat = $gemini->startChat();
        } else {
            $chat = $gemini->chat;
        }
        $result = $gemini->sendMessage($request->message);

        return response()->json([
            'chat_session' => $chat->getId(),
            'data' => $result
        ]);
    }

    public function startChat(array $history = [])
    {
        $this->chat = Gemini::chat()->startChat($history);
    }

    public function sendMessage(string $message)
    {
        return $this->chat->sendMessage($message);
    }
}
