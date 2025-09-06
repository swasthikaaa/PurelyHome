<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     * Optionally filter by role via ?role=admin or ?role=customer
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $role = $request->query('role');
            if (in_array($role, ['admin', 'customer'])) {
                $query->where('role', $role);
            }
        }

        $users = $query->with('phones', 'cart')->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // expects password_confirmation
            'role'     => ['required', Rule::in(['admin', 'customer'])],
            'address'  => 'nullable|string|max:1000',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // will be hashed by model cast
            'role'     => $validated['role'],
            'address'  => $validated['address'] ?? null,
        ]);

        return new UserResource($user->load('phones', 'cart'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return new UserResource($user->load('phones', 'cart'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'role'     => ['sometimes', 'required', Rule::in(['admin', 'customer'])],
            'address'  => 'nullable|string|max:1000',
        ]);

        // Update fields manually to handle password hashing if present
        if (isset($validated['password'])) {
            $user->password = $validated['password'];
            unset($validated['password']);
        }

        $user->update($validated);

        return new UserResource($user->load('phones', 'cart'));
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
