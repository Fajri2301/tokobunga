<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_contact_page_uses_the_current_database_address(): void
    {
        Setting::query()->create([
            'site_name' => 'Flora Test',
            'address' => 'Jl. Mawar No. 42, Jakarta',
        ]);

        $this->get(route('pages.contact'))
            ->assertOk()
            ->assertSee('Jl. Mawar No. 42, Jakarta');
    }
}
