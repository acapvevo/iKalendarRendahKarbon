<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('community/login');

        $response->assertStatus(200);
    }

    public function test_communities_can_authenticate_using_the_login_screen()
    {
        $community = Community::factory()->create();

        $response = $this->post('community/login', [
            'email' => $community->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('community');
        $response->assertRedirect(route('community.dashboard'));
    }

    public function test_communities_can_not_authenticate_with_invalid_password()
    {
        $community = Community::factory()->create();

        $this->post('community/login', [
            'email' => $community->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('community');
    }
}
