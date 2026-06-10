<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class GeminiServiceTest extends TestCase
{
    private GeminiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        // Mock API Key
        config(['services.gemini.key' => 'test-api-key']);
        $this->service = new GeminiService();
    }

    public function test_it_returns_response_when_api_call_is_successful()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Halo! Saya Flora Bot 🌸']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->service->getResponse('Halo', []);

        $this->assertEquals('Halo! Saya Flora Bot 🌸', $response);
    }

    public function test_it_returns_fallback_message_when_api_call_fails()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([], 500)
        ]);

        $response = $this->service->getResponse('Halo');

        $this->assertStringContainsString('Flora sedang sedikit bingung', $response);
    }

    public function test_it_returns_fallback_message_when_api_key_is_missing()
    {
        config(['services.gemini.key' => null]);
        
        $response = $this->service->getResponse('Halo');

        $this->assertStringContainsString('Flora sedang sedikit bingung', $response);
    }

    public function test_it_returns_fallback_message_when_quota_exceeded()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'error' => ['message' => 'Quota exceeded']
            ], 429)
        ]);

        $response = $this->service->getResponse('Halo');

        $this->assertStringContainsString('Flora sedang menerima banyak tamu', $response);
    }

    public function test_it_returns_error_fallback_message_on_general_error()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([], 500)
        ]);

        $response = $this->service->getResponse('Halo');

        $this->assertStringContainsString('Flora sedang sedikit bingung', $response);
    }
}
