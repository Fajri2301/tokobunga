<?php

namespace App\Services;

use App\Contracts\AIChatServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService implements AIChatServiceInterface
{
    protected ?string $apiKey;
    protected string $baseUrl = 'https://openrouter.ai/api/v1/';
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
        $this->model = env('MODEL', 'openai/gpt-3.5-turbo');
    }

    /**
     * @inheritDoc
     * @return string|array|null
     */
    public function getResponse(string $message, array $contextData = [], array $history = []): string|array|null
    {
        if (!$this->apiKey) {
            Log::warning('OpenRouter API Key missing in configuration');
            return null;
        }

        $messages = $this->prepareMessages($message, $contextData, $history);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])->post($this->baseUrl . 'chat/completions', [
                'model' => $this->model,
                'messages' => $messages,
            ]);

            if ($response->successful()) {
                $rawContent = $response->json('choices.0.message.content');
                
                // Bersihkan markdown block ```json ... ``` jika AI membandel
                $cleanedContent = preg_replace('/```(?:json)?\s*(.*?)\s*```/s', '$1', $rawContent);
                
                // Cek apakah respons adalah JSON command
                $decodedJson = json_decode(trim($cleanedContent), true);
                if (json_last_error() === JSON_ERROR_NONE && isset($decodedJson['action'])) {
                    return $decodedJson; // Kembalikan sebagai array jika ini adalah JSON command
                }

                if (is_string($rawContent)) {
                    // Bersihkan markdown dan kembalikan sebagai string biasa
                    return str_replace('**', '', $rawContent);
                }

                return $rawContent;
            }

            Log::error('OpenRouter API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return "Maaf, asisten AI sedang sibuk. Silakan coba lagi nanti.";

        } catch (\Exception $e) {
            Log::error('OpenRouter Service Exception: ' . $e->getMessage());
            return "Maaf, terjadi kesalahan saat menghubungi asisten AI.";
        }
    }

    protected function prepareMessages(string $message, array $contextData, array $history): array
    {
        $messages = [];

        $messages[] = [
            'role' => 'system',
            'content' => $this->buildSystemInstruction($contextData)
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'bot' ? 'assistant' : 'user',
                'content' => $msg['content']
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        return $messages;
    }

    protected function buildSystemInstruction(array $contextData): string
    {
        $instruction = "Kamu adalah Flora Bot, asisten virtual profesional dari Toko Bunga Flora. Tugasmu adalah membantu pelanggan dengan ramah, hangat, dan informatif.

";
        
        $instruction .= "PANDUAN INTERAKSI:
";
        $instruction .= "1. Jawablah secara singkat dan padat (maksimal 3-4 kalimat).
";
        $instruction .= "2. Gunakan emoji bunga seperti 🌸, 🌹, 🌻 secara wajar.
";
        $instruction .= "3. JANGAN gunakan format markdown seperti tebal (tanda bintang **) atau miring.

";
        
        $instruction .= "ATURAN SPESIAL:
";
        $instruction .= "- Jika pengguna secara spesifik meminta untuk melihat GAMBAR atau FOTO sebuah produk, JANGAN menjawab dengan kalimat. Jawab HANYA dengan format JSON ini:
";
        $instruction .= "{\"action\": \"show_image\", \"product_name\": \"NAMA_PRODUK_YANG_DIMINTA\"}
";
        $instruction .= "- Contoh: jika user bilang 'lihat foto buket bunga 4', respons kamu HANYA: {\"action\": \"show_image\", \"product_name\": \"Buket Bunga 4\"}

";

        if (!empty($contextData['products'])) {
            $instruction .= "DATA PRODUK TERSEDIA:
";
            foreach ($contextData['products'] as $p) {
                $name = is_object($p) ? $p->name : $p['name'];
                $price = is_object($p) ? $p->price : $p['price'];
                $instruction .= "- {$name}: Rp " . number_format($price, 0, ',', '.') . "
";
            }
            $instruction .= "
";
        }

        if (!empty($contextData['store_info'])) {
            $instruction .= "INFORMASI TOKO:
";
            foreach ($contextData['store_info'] as $key => $value) {
                $instruction .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}
";
            }
        }

        return $instruction;
    }
}
