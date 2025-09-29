<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthOtpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_login_with_otp()
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => bcrypt('test123'),
            'role' => 'customer',
            'status' => 'active',
        ]);

        // Step 1: Post login
        $response = $this->post('/login', [
            'email' => 'customer@example.com',
            'password' => 'test123',
        ]);

        $response->assertRedirect('/otp-verify');

        // Step 2: Simulate OTP (from DB)
        $otp = $user->fresh()->login_otp;

        $verify = $this->post('/otp-verify', [
            'otp' => $otp,
        ]);

        $verify->assertRedirect('/dashboard');
    }
}
