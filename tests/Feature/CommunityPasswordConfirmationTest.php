<?php

namespace Tests\Feature;

use App\Models\Community;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityPasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $community = Community::factory()->create();

        $response = $this->actingAs($community, 'community')->get('community/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $community = Community::factory()->create();

        $response = $this->actingAs($community, 'community')->post('community/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $community = Community::factory()->create();

        $response = $this->actingAs($community, 'community')->post('community/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
