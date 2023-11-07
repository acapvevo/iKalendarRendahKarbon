<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResidentAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('resident/login');

        $response->assertStatus(200);
    }

    public function test_residents_can_authenticate_using_the_login_screen()
    {
        $resident = Resident::factory()->create();

        $response = $this->post('resident/login', [
            'email' => $resident->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('resident');
        $response->assertRedirect(route('resident.dashboard'));
    }

    public function test_residents_can_not_authenticate_with_invalid_password()
    {
        $resident = Resident::factory()->create();

        $this->post('resident/login', [
            'email' => $resident->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('resident');
    }
}
