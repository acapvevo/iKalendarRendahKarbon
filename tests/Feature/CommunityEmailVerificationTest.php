<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CommunityEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $community = Community::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($community, 'community')->get('community/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $community = Community::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'community.verification.verify',
            now()->addMinutes(60),
            ['id' => $community->id, 'hash' => sha1($community->email)]
        );

        $response = $this->actingAs($community, 'community')->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($community->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('community.dashboard').'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $community = Community::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'community.verification.verify',
            now()->addMinutes(60),
            ['id' => $community->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($community, 'community')->get($verificationUrl);

        $this->assertFalse($community->fresh()->hasVerifiedEmail());
    }
}
