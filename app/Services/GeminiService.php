<?php

namespace App\Services;

use App\Contracts\AIChatServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService implements AIChatServiceInterface
{
    protected ?string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');
    }

    /**
     * @inheritDoc
     */
    public function getResponse(string $message, array $contextData = [], array $history = []): ?string
    {
        if (!$this->apiKey) {
            Log::warning('Gemini API Key missing in configuration');
            return null;
        }

        $url = "{$this->baseUrl}{$this->model}:generateContent?key={$this->apiKey}";
        
        $contents = $this->prepareContents($message, $history);
        $systemInstruction = $this->buildSystemInstruction($contextData);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => $contents,
                'system_instruction' => [
                    'parts' => [
                        ['text' => $systemInstruction]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1000,
                ]
            ]);

            if ($response->successful()) {
                $candidates = $response->json('candidates', []);
                if (!empty($candidates) && isset($candidates[0]['content']['parts'][0]['text'])) {
                    return trim($candidates[0]['content']['parts'][0]['text']);
                }
                
                Log::warning('Gemini API returned successful but with empty candidates', ['body' => $response->json()]);
                return null;
            }

            if ($response->status() === 429) {
                return "Maaf ya, Flora sedang menerima banyak tamu nih. 🌸 Boleh tunggu sebentar atau langsung hubungi admin via WhatsApp ya! Terimakasih kesabarannya. 😊";
            }

            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $url
            ]);
            
            return "Aduh, sepertinya Flora sedang sedikit bingung. 🌿 Bisa diulangi pertanyaannya? Atau hubungi tim kami jika mendesak ya!";
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return "Aduh, sepertinya Flora sedang sedikit bingung. 🌿 Bisa diulangi pertanyaannya? Atau hubungi tim kami jika mendesak ya!";
        }
    }

    protected function prepareContents(string $message, array $history): array
    {
        $contents = [];

        // Add history
        foreach ($history as $msg) {
            $role = $msg['role'] === 'bot' ? 'model' : 'user';
            $contents[] = [
                'role' => $role,
                'parts' => [
                    ['text' => $msg['content']]
                ]
            ];
        }

        // Add current message
        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $message]
            ]
        ];

        return $contents;
    }

    protected function buildSystemInstruction(array $contextData): string
    {
        $instruction = "Kamu adalah Flora Bot, asisten virtual profesional dari Toko Bunga Flora. ";
        $instruction .= "Tugasmu adalah membantu pelanggan memilih bunga, memberikan informasi harga, dan menjawab pertanyaan seputar toko dengan ramah, hangat, dan informatif.\n\n";
        
        $instruction .= "PANDUAN INTERAKSI:\n";
        $instruction .= "1. Gunakan bahasa Indonesia yang santun namun tetap akrab.\n";
        $instruction .= "2. Jawablah secara singkat dan padat (maksimal 3-4 kalimat).\n";
        $instruction .= "3. Gunakan emoji bunga seperti 🌸, 🌹, 🌻 secara wajar.\n";
        $instruction .= "4. Jika pelanggan bertanya tentang harga yang tidak ada di konteks, arahkan untuk bertanya langsung ke admin atau cek katalog.\n\n";

        if (!empty($contextData['products'])) {
            $instruction .= "DATA PRODUK TERSEDIA:\n";
            foreach ($contextData['products'] as $p) {
                $name = is_object($p) ? $p->name : $p['name'];
                $price = is_object($p) ? $p->price : $p['price'];
                $instruction .= "- {$name}: Rp " . number_format($price, 0, ',', '.') . "\n";
            }
            $instruction .= "\n";
        }

        if (!empty($contextData['store_info'])) {
            $instruction .= "INFORMASI TOKO:\n";
            foreach ($contextData['store_info'] as $key => $value) {
                $instruction .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
            }
        }

        return $instruction;
    }
}
