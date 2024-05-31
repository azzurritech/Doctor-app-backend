<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $user = User::create($validator->validated());

        return response(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response(['user' => $user, 'token' => $token]);
        }
        return response(['message' => 'Invalid credentials'], 401);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->stateless()->user();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Google authentication failed']);
    }

    // Check if a user with the same email already exists in the database.
    $existingUser = User::where('email', $user->email)->first();

    if ($existingUser) {
        // If the user exists, log them in.
        Auth::login($existingUser);

        // Generate an API token if you want to use token-based authentication.
        $token = $existingUser->createToken('authToken')->plainTextToken;

        return response()->json(['message' => 'Logged in successfully', 'token' => $token]);
    } else {
        // If the user doesn't exist, create a new user.
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            // You can set additional user attributes here.
        ]);

        // Log in the new user.
        Auth::login($newUser);

        // Generate an API token if you want to use token-based authentication.
        $token = $newUser->createToken('authToken')->plainTextToken;

        return response()->json(['message' => 'User registered and logged in successfully', 'token' => $token]);
    }
}



    
    // public function handleGoogleCallback()
    // {
    //     $user = Socialite::driver('google')->stateless()->user();
    
    //     // Your authentication logic here
    
    //     return response()->json(['user' => $user]);
    // }
    
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }
    
    // public function handleFacebookCallback()
    // {
    //     $user = Socialite::driver('facebook')->stateless()->user();
    
    //     // Your authentication logic here
    
    //     return response()->json(['user' => $user]);
    // }   
    
      public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Facebook authentication failed']);
        }

        // Check if a user with the same email already exists in the database.
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // If the user exists, log them in.
            Auth::login($existingUser);

            // Generate an API token if you want to use token-based authentication.
            $token = $existingUser->createToken('authToken')->plainTextToken;

            return response()->json(['message' => 'Logged in successfully', 'token' => $token]);
        } else {
            // If the user doesn't exist, create a new user.
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                // You can set additional user attributes here.
            ]);

            // Log in the new user.
            Auth::login($newUser);

            // Generate an API token if you want to use token-based authentication.
            $token = $newUser->createToken('authToken')->plainTextToken;

            return response()->json(['message' => 'User registered and logged in successfully', 'token' => $token]);
        }
    }

}

