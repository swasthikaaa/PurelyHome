<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'digits:10', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'name.required'     => 'Full name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Enter a valid email address.',
            'email.unique'      => 'This email is already registered.',
            'phone.required'    => 'Phone number is required.',
            'phone.digits'      => 'Phone number must be exactly 10 digits.',
            'phone.unique'      => 'This phone number is already registered.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',
            'password.confirmed'=> 'Password confirmation does not match.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'status'   => 'active',
            'role'     => 'customer',
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', '✅ Registration successful! Please log in.');
    }

    /**
     * API login (returns Sanctum token).
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => __('auth.failed')], 401);
        }

        if ($user->status !== 'active') {
            return response()->json(['success' => false, 'message' => 'Account is deactivated. Contact support.'], 403);
        }

        // Remove old tokens
        $user->tokens()->delete();

        // Create fresh Sanctum token
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => '✅ Login successful',
            'user'    => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'role'   => $user->role,
                'status' => $user->status,
            ],
            'token'   => $token,
        ], 200);
    }

    /**
     * Logout current API token.
     */
    public function logoutApi(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['success' => true, 'message' => 'Logged out successfully']);
        }
        return response()->json(['success' => false, 'message' => 'No active session found'], 400);
    }

    /**
     * Logout all tokens for current user.
     */
    public function logoutAll(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
            return response()->json(['success' => true, 'message' => 'Logged out from all devices']);
        }
        return response()->json(['success' => false, 'message' => 'No active session found'], 400);
    }

    // ---------------- Password Reset ----------------

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'request' => $request,
            'token'   => $token,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Your password has been reset. Please log in with your new password.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
