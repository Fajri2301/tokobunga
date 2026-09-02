<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    private function attemptLogin(string $email = 'admin@example.com'): TestResponse
    {
        return $this->post(route('login.post'), [
            'email' => $email,
            'password' => 'wrong-password',
        ]);
    }

    public function test_successful_login_resets_throttle(): void
    {
        $user = User::factory()->create();

        // Beberapa percobaan gagal
        for ($i = 0; $i < 3; $i++) {
            $this->attemptLogin($user->email);
        }

        // Login benar harus tetap berhasil (belum kena limit)
        $response = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_locks_out_after_too_many_attempts(): void
    {
        $email = 'victim@example.com';

        for ($i = 0; $i < 5; $i++) {
            $this->attemptLogin($email);
        }

        $response = $this->attemptLogin($email);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            'Terlalu banyak percobaan',
            session('errors')->get('email')[0]
        );
    }
}
