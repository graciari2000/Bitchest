<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'phone' => 'nullable|string',
                'address' => 'nullable|string',
            ]);

            // Generate API token
            $apiToken = Str::random(60);
            
            // Create user with default values
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'api_token' => hash('sha256', $apiToken),
                'role' => 'client', // Default role
                'balance' => 10000.00, // Default starting balance
                'is_active' => true,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'balance' => $user->balance,
                    'is_active' => $user->is_active,
                ],
                'token' => $apiToken
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Registration failed',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 401);
            }

            if (!$user->is_active) {
                return response()->json([
                    'message' => 'Account is deactivated'
                ], 403);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Generate new token
            $apiToken = Str::random(60);
            $user->api_token = hash('sha256', $apiToken);
            $user->save();

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'balance' => $user->balance,
                    'is_active' => $user->is_active,
                ],
                'token' => $apiToken
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Login failed',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->api_token = null;
            $user->save();
            
            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['message' => 'Logout failed'], 500);
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id' => (string)$user->_id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'balance' => $user->balance,
            'is_active' => $user->is_active,
            'phone' => $user->phone,
            'address' => $user->address,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }
}
