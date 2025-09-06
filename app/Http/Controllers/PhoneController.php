<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;
use App\Http\Resources\PhoneResource;

class PhoneController extends Controller
{
    /**
     * Display a listing of phones.
     */
    public function index()
    {
        $phones = Phone::with('user')->get();
        return PhoneResource::collection($phones);
    }

    /**
     * Store a newly created phone.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone'   => 'required|string|max:20',
        ]);

        $phone = Phone::create($validated);

        return new PhoneResource($phone);
    }

    /**
     * Display the specified phone.
     */
    public function show(Phone $phone)
    {
        return new PhoneResource($phone->load('user'));
    }

    /**
     * Update the specified phone.
     */
    public function update(Request $request, Phone $phone)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'phone'   => 'sometimes|string|max:20',
        ]);

        $phone->update($validated);

        return new PhoneResource($phone);
    }

    /**
     * Remove the specified phone.
     */
    public function destroy(Phone $phone)
    {
        $phone->delete();

        return response()->json(['message' => 'Phone deleted successfully.']);
    }
}
