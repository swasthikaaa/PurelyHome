<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Order;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $user = User::with('orders')->find(1);
    return $user ?: response()->json(['error' => 'User not found'], 404);
});
