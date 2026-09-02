<?php

namespace Tests\Feature;

use App\Events\NewOrderEvent;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);

        // Seed settings for testing
        Setting::factory()->create([
            'whatsapp_number' => '628123456789',
            'site_name' => 'Toko Bunga Test',
        ]);
    }

    public function test_can_add_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->postJson(route('cart.add', $product->id));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'cart_count' => 1,
            ]);

        $this->assertEquals(1, count(session('cart')));
    }

    public function test_can_checkout_and_generate_whatsapp_link()
    {
        Event::fake([NewOrderEvent::class]);

        $product = Product::factory()->create(['price' => 100000]);

        // Mocking session cart
        session(['cart' => [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => $product->price,
                'image' => $product->image,
                'slug' => $product->slug,
            ],
        ]]);

        $payload = [
            'customer_name' => 'John Doe',
            'customer_phone' => '0812345678',
            'customer_address' => 'Jl. Bunga No. 1',
        ];

        $response = $this->postJson(route('cart.checkout'), $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'redirect_url']);

        $this->assertStringContainsString('https://api.whatsapp.com/send', $response->json('redirect_url'));
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'John Doe',
            'total_price' => 200000,
        ]);

        $this->assertEmpty(session('cart'));
    }

    public function test_checkout_ignores_tampered_session_prices()
    {
        Event::fake([NewOrderEvent::class]);

        $product = Product::factory()->create(['price' => 100000]);

        // Harga di session sengaja dipalsukan lebih murah dari DB
        session(['cart' => [
            $product->id => [
                'name' => $product->name,
                'quantity' => 2,
                'price' => 1, // manipulasi
                'image' => $product->image,
                'slug' => $product->slug,
            ],
        ]]);

        $payload = [
            'customer_name' => 'Jane Doe',
            'customer_phone' => '0812345678',
            'customer_address' => 'Jl. Bunga No. 2',
        ];

        $response = $this->postJson(route('cart.checkout'), $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', ['total_price' => 200000]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'price' => 100000, // harga asli DB, bukan harga palsu session
            'quantity' => 2,
        ]);
    }

    public function test_checkout_skips_deleted_products_and_saves_valid_items_only()
    {
        Event::fake([NewOrderEvent::class]);

        $product = Product::factory()->create(['price' => 50000]);
        $deletedProduct = Product::factory()->create(['price' => 99000]);
        $deletedProduct->delete(); // soft delete

        session(['cart' => [
            $product->id => [
                'name' => $product->name, 'quantity' => 1, 'price' => 50000,
                'image' => $product->image, 'slug' => $product->slug,
            ],
            $deletedProduct->id => [
                'name' => $deletedProduct->name, 'quantity' => 3, 'price' => 99000,
                'image' => $deletedProduct->image, 'slug' => $deletedProduct->slug,
            ],
        ]]);

        $response = $this->postJson(route('cart.checkout'), [
            'customer_name' => 'Test',
            'customer_phone' => '0812345678',
            'customer_address' => 'Jl. Test',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', ['total_price' => 50000]);
    }
}
