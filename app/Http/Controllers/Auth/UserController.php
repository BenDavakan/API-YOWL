<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'age' => ['required', 'integer'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $new_user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'age' => $fields['age'],
            'password' =>  bcrypt($fields['password'])
        ]);
        $token = $new_user->createToken('myApiToken')->plainTextToken;
        $response = [
            'user' => $new_user,
            'token' => $token,
            'message' => 'User create successfully'
        ];

        return response($response, 200);
    }
    // Login
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string']
        ]);

        // validate email address
        $user = User::where('email', $fields['email'])->first();

        // validate password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            $response = [
                'message' => 'Bad parameters',
            ];
            return response($response, 401);
        }
        $token = $user->createToken('myApiToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Success'
        ];

        return response($response, 201);
    }

    // Logout
    public function logout()
    {

        auth()->user()->tokens()->delete();
        $response = [
            'message' => 'Logged out'
        ];
        return response($response);
    }
    // Auth informations
    public function authinfo()
    {
        $response = [
            'auth' => auth()->user()
        ];
        return response($response);
    }
}
