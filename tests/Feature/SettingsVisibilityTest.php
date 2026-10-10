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
            'id' => 1,
            'site_name' => 'Flora Test',
            'address' => 'Jl. Mawar No. 42, Jakarta',
        ]);

        // CI uses MySQL and can reuse an application instance across tests.
        // Ensure the view composer resolves the settings fixture created above.
        app()->forgetInstance('settings');

        $this->get(route('pages.contact'))
            ->assertOk()
            ->assertSee('Jl. Mawar No. 42, Jakarta');
    }
}
