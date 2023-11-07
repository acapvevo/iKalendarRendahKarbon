<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ResidentEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $resident = Resident::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($resident, 'resident')->get('resident/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $resident = Resident::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'resident.verification.verify',
            now()->addMinutes(60),
            ['id' => $resident->id, 'hash' => sha1($resident->email)]
        );

        $response = $this->actingAs($resident, 'resident')->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($resident->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('resident.dashboard').'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $resident = Resident::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'resident.verification.verify',
            now()->addMinutes(60),
            ['id' => $resident->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($resident, 'resident')->get($verificationUrl);

        $this->assertFalse($resident->fresh()->hasVerifiedEmail());
    }
}
