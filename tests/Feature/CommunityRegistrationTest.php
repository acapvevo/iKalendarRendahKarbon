<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('community/register');

        $response->assertStatus(200);
    }

    public function test_new_communities_can_register()
    {
        $response = $this->post('community/register', [
            'name' => 'Test Community',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated('community');
        $response->assertRedirect(route('community.dashboard'));
    }
}
