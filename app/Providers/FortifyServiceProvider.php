<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Models\User;
use App\Mail\OtpMail;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Fortify actions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // ✅ After registration → logout and force login again
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return $request->expectsJson()
                    ? response()->json(['message' => 'Account created successfully! Please log in.'])
                    : redirect()->route('login')->with('success', 'Account created successfully! Please log in.');
            }
        });

        // ✅ Custom authentication logic
        Fortify::authenticateUsing(function (Request $request) {
            $email = strtolower($request->email);
            $password = $request->password;

            // Admin Login (direct, skip OTP)
            if ($email === 'admin@purelyhome.com' && $password === 'password123') {
                $admin = User::firstOrCreate(
                    ['email' => 'admin@purelyhome.com'],
                    [
                        'name'     => 'Admin',
                        'password' => Hash::make('password123'),
                        'role'     => 'admin',
                        'status'   => 'active',
                    ]
                );
                return $admin;
            }

            // 🧑 Normal user
            $user = User::where('email', $email)->first();
            if ($user && Hash::check($password, $user->password)) {
                if ($user->role === 'customer' && $user->status !== 'active') {
                    return null; // block inactive customers
                }
                return $user;
            }

            return null;
        });

        // ✅ Custom login response
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = Auth::user();
                    if (!$user) {
                        return $request->expectsJson()
                            ? response()->json(['message' => 'Unauthorized login attempt.'], 401)
                            : redirect()->route('login')->withErrors(['email' => 'Unauthorized login attempt.']);
                    }

                    // 🔑 Always create Sanctum token
                    $token = $user->createToken('login-token')->plainTextToken;

                    // 📌 API / Postman → return JSON with token
                    if ($request->expectsJson() || $request->is('api/*')) {
                        return response()->json([
                            'user'  => $user,
                            'token' => $token,
                        ]);
                    }

                    // 👨‍💼 Admin → direct route (no OTP)
                    if ($user->role === 'admin') {
                        session(['auth_token' => $token]);
                        return redirect()->route('admin.products.index');
                    }

                    // 🧑 Customer → OTP flow
                    if ($user->role === 'customer') {
                        $otp = rand(100000, 999999);
                        $user->login_otp = $otp;
                        $user->otp_expires_at = now()->addMinutes(5);
                        $user->save();

                        // ✅ Send branded OTP email
                        try {
                            Mail::to($user->email)->send(new OtpMail($user, $otp));
                        } catch (\Exception $e) {
                            \Log::error("OTP email failed: " . $e->getMessage());
                        }

                        session([
                            'pending_user_id'    => $user->id,
                            'pending_user_email' => $user->email,
                        ]);

                        Auth::logout(); // ✅ require OTP before login
                        return redirect()->route('otp.verify');
                    }

                    // Fallback → just send to dashboard
                    session(['auth_token' => $token]);
                    return redirect()->route('dashboard');
                }
            };
        });

        // ✅ Rate limiting
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
