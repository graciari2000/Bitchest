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
                'role' => 'nullable|string|in:admin,user', // Accept role from request
            ]);

            // Determine role: use provided role or default to 'user'
            $role = $validated['role'] ?? 'user';
            // Only allow 'admin' or 'user' roles
            if (!in_array($role, ['admin', 'user'])) {
                $role = 'user';
            }

            // Enforce single-admin rule: only allow creating an admin if none exists yet.
            // If an admin already exists, force the role to 'user' regardless of request.
            if ($role === 'admin') {
                $adminExists = User::where('role', 'admin')->exists();
                if ($adminExists) {
                    // Log for auditing and silently downgrade to 'user'
                    \Log::warning('Attempt to create additional admin during registration for email: ' . ($validated['email'] ?? 'unknown'));
                    $role = 'user';
                }
            }

            // Create user with default values
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
                'balance' => 500.00, // Auto-credit €500 during prototyping phase
                'is_active' => true,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            // Create Sanctum token
            $token = $user->createToken('auth-token')->plainTextToken;

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
                'token' => $token
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

            // Revoke all existing tokens and create new one (MongoDB-compatible)
            $user->deleteTokens();
            $token = $user->createToken('auth-token')->plainTextToken;

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
                'token' => $token
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
            // Revoke the current token
            $request->user()->currentAccessToken()?->delete();

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
