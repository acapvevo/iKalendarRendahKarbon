<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResidentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('resident/register');

        $response->assertStatus(200);
    }

    public function test_new_residents_can_register()
    {
        $response = $this->post('resident/register', [
            'name' => 'Test Resident',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated('resident');
        $response->assertRedirect(route('resident.dashboard'));
    }
}
