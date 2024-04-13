<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $rawApiToken = \Str::random(10);

        $userData = [
            'name' => 'John Smith',
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'api_token' => $rawApiToken,
        ];

        $user = User::create($userData);

        return [
            'apiToken' => $rawApiToken
        ];
    }
}
