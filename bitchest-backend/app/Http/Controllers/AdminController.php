<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Get all clients
     */
    public function clients(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $clients = User::where('role', 'client')->paginate(20);

        return response()->json($clients);
    }

    /**
     * Get client details
     */
    public function clientDetails(Request $request, $clientId)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $client = User::with(['transactions', 'portfolio'])->findOrFail($clientId);

        return response()->json($client);
    }

    /**
     * Create new client
     */
    public function createClient(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Generate temporary password
        $tempPassword = Str::random(12);

        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => 'client',
            'balance' => 500.00, // Auto-credit €500 during prototyping
            'is_active' => true,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'message' => 'Client created successfully',
            'client' => $client,
            'temporary_password' => $tempPassword, // Return temp password for admin
        ], 201);
    }

    /**
     * Update client information
     */
    public function updateClient(Request $request, $clientId)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $client = User::findOrFail($clientId);

        if ($client->role !== 'client') {
            return response()->json(['message' => 'User is not a client.'], 400);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $clientId,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_active' => 'sometimes|boolean',
            'balance' => 'sometimes|numeric|min:0',
        ]);

        $client->update($request->only(['name', 'email', 'phone', 'address', 'is_active', 'balance']));

        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $client,
        ]);
    }

    /**
     * Delete client
     */
    public function deleteClient(Request $request, $clientId)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $client = User::findOrFail($clientId);

        if ($client->role !== 'client') {
            return response()->json(['message' => 'User is not a client.'], 400);
        }

        // Delete related data
        Transaction::where('user_id', $clientId)->delete();
        Wallet::where('user_id', $clientId)->delete();

        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully',
        ]);
    }

    /**
     * Generate temporary password for client
     */
    public function generateTempPassword(Request $request, $clientId)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $client = User::findOrFail($clientId);

        if ($client->role !== 'client') {
            return response()->json(['message' => 'User is not a client.'], 400);
        }

        $tempPassword = Str::random(12);
        $client->password = Hash::make($tempPassword);
        $client->save();

        return response()->json([
            'message' => 'Temporary password generated successfully',
            'temporary_password' => $tempPassword,
        ]);
    }

    /**
     * Update admin's own personal information
     */
    public function updateProfile(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $request->user()->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $request->user()->update($request->only(['name', 'email', 'phone', 'address']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $request->user()->fresh(),
        ]);
    }

    /**
     * Get all cryptocurrencies
     */
    public function cryptocurrencies(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $cryptos = Crypto::orderBy('market_cap', 'desc')->get();

        return response()->json($cryptos);
    }

    /**
     * Get platform statistics
     */
    public function statistics(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $totalClients = User::where('role', 'client')->count();
        $activeClients = User::where('role', 'client')->where('is_active', true)->count();
        $totalTransactions = Transaction::count();
        $totalBalance = User::where('role', 'client')->sum('balance');
        $totalWallets = Wallet::count();

        return response()->json([
            'total_clients' => $totalClients,
            'active_clients' => $activeClients,
            'total_transactions' => $totalTransactions,
            'total_balance' => $totalBalance,
            'total_wallets' => $totalWallets,
        ]);
    }

    /**
     * Get all transactions
     */
    public function transactions(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json($transactions);
    }
}
