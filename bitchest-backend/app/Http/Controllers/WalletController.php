<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Crypto;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Get user's wallet contents
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get all wallet entries for the user
        $wallets = Wallet::where('user_id', $user->id)->get();

        // Update current prices and calculations
        foreach ($wallets as $wallet) {
            $crypto = Crypto::where('symbol', $wallet->crypto_symbol)->first();
            if ($crypto) {
                $wallet->current_price = $crypto->current_price;
                $wallet->total_value = $wallet->amount * $crypto->current_price;
                $wallet->profit_loss = $wallet->total_value - ($wallet->amount * $wallet->average_purchase_price);
                $wallet->profit_loss_percentage = $wallet->average_purchase_price > 0
                    ? (($wallet->profit_loss / ($wallet->amount * $wallet->average_purchase_price)) * 100)
                    : 0;
                $wallet->save();
            }
        }

        // Get purchase history for each crypto
        $walletsWithHistory = $wallets->map(function ($wallet) use ($user) {
            $purchaseHistory = Transaction::where('user_id', $user->id)
                ->where('crypto_symbol', $wallet->crypto_symbol)
                ->where('type', 'buy')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($transaction) {
                    return [
                        'date' => $transaction->created_at->format('Y-m-d H:i:s'),
                        'quantity' => $transaction->amount,
                        'purchase_price' => $transaction->price,
                        'total' => $transaction->total,
                    ];
                });

            return [
                'id' => $wallet->id,
                'crypto_symbol' => $wallet->crypto_symbol,
                'crypto_name' => $wallet->crypto_name,
                'amount' => $wallet->amount,
                'average_purchase_price' => $wallet->average_purchase_price,
                'current_price' => $wallet->current_price,
                'total_value' => $wallet->total_value,
                'profit_loss' => $wallet->profit_loss,
                'profit_loss_percentage' => $wallet->profit_loss_percentage,
                'purchase_history' => $purchaseHistory,
            ];
        });

        return response()->json([
            'wallets' => $walletsWithHistory,
            'euro_balance' => $user->balance,
        ]);
    }

    /**
     * Get Euro balance (always visible)
     */
    public function balance(Request $request)
    {
        return response()->json([
            'balance' => $request->user()->balance,
        ]);
    }

    /**
     * Sell cryptocurrency
     */
    public function sell(Request $request)
    {
        $request->validate([
            'crypto_symbol' => 'required|string',
            'amount' => 'required|numeric|min:0.00000001',
        ]);

        $user = $request->user();
        $wallet = Wallet::where('user_id', $user->id)
            ->where('crypto_symbol', $request->crypto_symbol)
            ->first();

        if (!$wallet || $wallet->amount < $request->amount) {
            return response()->json([
                'message' => 'Insufficient cryptocurrency holdings',
            ], 400);
        }

        $crypto = Crypto::where('symbol', $request->crypto_symbol)->first();
        if (!$crypto) {
            return response()->json([
                'message' => 'Cryptocurrency not found',
            ], 404);
        }

        $price = $crypto->current_price;
        $total = $request->amount * $price;

        // Update wallet
        $wallet->amount -= $request->amount;
        if ($wallet->amount <= 0) {
            $wallet->delete();
        } else {
            // Recalculate average purchase price (FIFO method simplified)
            // For simplicity, we keep the average price the same
            $wallet->current_price = $price;
            $wallet->total_value = $wallet->amount * $price;
            $wallet->profit_loss = $wallet->total_value - ($wallet->amount * $wallet->average_purchase_price);
            $wallet->profit_loss_percentage = $wallet->average_purchase_price > 0
                ? (($wallet->profit_loss / ($wallet->amount * $wallet->average_purchase_price)) * 100)
                : 0;
            $wallet->save();
        }

        // Add balance to user
        $user->balance += $total;
        $user->save();

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'sell',
            'crypto_symbol' => $request->crypto_symbol,
            'crypto_name' => $crypto->name,
            'amount' => $request->amount,
            'price' => $price,
            'total' => $total,
            'status' => 'completed',
            'purchase_date' => now(),
        ]);

        return response()->json([
            'message' => 'Cryptocurrency sold successfully',
            'transaction' => $transaction,
            'new_balance' => $user->balance,
        ], 201);
    }
}

