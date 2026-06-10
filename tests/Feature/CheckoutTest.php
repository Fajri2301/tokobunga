<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        
        // Seed settings for testing
        Setting::factory()->create([
            'whatsapp_number' => '628123456789',
            'site_name' => 'Toko Bunga Test'
        ]);
    }

    public function test_can_add_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->postJson(route('cart.add', $product->id));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'cart_count' => 1
            ]);

        $this->assertEquals(1, count(session('cart')));
    }

    public function test_can_checkout_and_generate_whatsapp_link()
    {
        \Illuminate\Support\Facades\Event::fake([\App\Events\NewOrderEvent::class]);

        $product = Product::factory()->create(['price' => 100000]);
        
        // Mocking session cart
        session(['cart' => [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => $product->price,
                'image' => $product->image,
                'slug' => $product->slug
            ]
        ]]);

        $payload = [
            'customer_name' => 'John Doe',
            'customer_phone' => '0812345678',
            'customer_address' => 'Jl. Bunga No. 1'
        ];

        $response = $this->postJson(route('cart.checkout'), $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'redirect_url']);

        $this->assertStringContainsString('https://api.whatsapp.com/send', $response->json('redirect_url'));
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'John Doe',
            'total_price' => 200000
        ]);
        
        $this->assertEmpty(session('cart'));
    }
}
