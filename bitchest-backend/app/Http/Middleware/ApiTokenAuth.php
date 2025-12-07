<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Get token from Authorization header
        $token = $request->bearerToken();
        
        if (!$token) {
            // Try query parameter as fallback
            $token = $request->query('api_token');
        }

        if (!$token) {
            return response()->json([
                'message' => 'Authentication token required',
                'error' => 'NO_TOKEN_PROVIDED'
            ], 401);
        }

        // Find user by hashed token
        $user = User::where('api_token', hash('sha256', $token))->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid authentication token',
                'error' => 'INVALID_TOKEN'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'message' => 'Account is deactivated',
                'error' => 'ACCOUNT_DEACTIVATED'
            ], 403);
        }

        // Bind user to request
        auth()->setUser($user);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
