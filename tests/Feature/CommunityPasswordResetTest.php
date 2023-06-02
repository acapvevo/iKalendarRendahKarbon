<?php

namespace Tests\Feature;

use App\Models\Community;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommunityPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('community/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $community = Community::factory()->create();

        $response = $this->post('community/forgot-password', [
            'email' => $community->email,
        ]);

        Notification::assertSentTo($community, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $community = Community::factory()->create();

        $response = $this->post('community/forgot-password', [
            'email' => $community->email,
        ]);

        Notification::assertSentTo($community, ResetPassword::class, function ($notification) {
            $response = $this->get('community/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $community = Community::factory()->create();

        $response = $this->post('community/forgot-password', [
            'email' => $community->email,
        ]);

        Notification::assertSentTo($community, ResetPassword::class, function ($notification) use ($community) {
            $response = $this->post('community/reset-password', [
                'token' => $notification->token,
                'email' => $community->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
