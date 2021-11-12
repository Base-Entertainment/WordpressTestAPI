<?php

namespace App\Http\Controllers;

use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'required|string|unique',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'login' => $fields['username'],
            'email' => $fields['email'],
            'user_pass' => bcrypt($fields['password']),
            'first_name' => $fields['firstname'],
            'last_name' => $fields['lastname'],
            'capabilities' => 'a:1:{s:10:"subscriber";b:1;}', // As a default, It's registered as a 'subscriber'
        ]);
    }
}
