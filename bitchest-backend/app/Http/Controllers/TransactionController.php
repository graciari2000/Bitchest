<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Crypto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Get user's transactions
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($transactions);
    }

    /**
     * Create a new transaction (buy/sell)
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:buy,sell',
            'crypto_symbol' => 'required|string',
            'amount' => 'required|numeric|min:0.00000001',
        ]);

        $user = $request->user();
        $crypto = Crypto::where('symbol', $request->crypto_symbol)->first();

        if (!$crypto) {
            return response()->json([
                'message' => 'Cryptocurrency not found',
            ], 404);
        }

        $price = $crypto->current_price;
        $total = $request->amount * $price;

        if ($request->type === 'buy') {
            // Check if user has enough balance
            if ($user->balance < $total) {
                return response()->json([
                    'message' => 'Insufficient balance',
                ], 400);
            }

            // Deduct balance
            $user->balance -= $total;
            $user->save();

            // Update or create wallet
            $wallet = Wallet::where('user_id', $user->id)
                ->where('crypto_symbol', $request->crypto_symbol)
                ->first();

            if ($wallet) {
                // Calculate new average price
                $totalAmount = $wallet->amount + $request->amount;
                $totalInvested = ($wallet->amount * $wallet->average_purchase_price) + $total;
                $newAveragePrice = $totalInvested / $totalAmount;

                $wallet->amount = $totalAmount;
                $wallet->average_purchase_price = $newAveragePrice;
                $wallet->current_price = $price;
                $wallet->total_value = $totalAmount * $price;
                $wallet->profit_loss = $wallet->total_value - ($totalAmount * $newAveragePrice);
                $wallet->profit_loss_percentage = $newAveragePrice > 0
                    ? (($wallet->profit_loss / ($totalAmount * $newAveragePrice)) * 100)
                    : 0;
                $wallet->save();
            } else {
                Wallet::create([
                    'user_id' => $user->id,
                    'crypto_symbol' => $request->crypto_symbol,
                    'crypto_name' => $crypto->name,
                    'amount' => $request->amount,
                    'average_purchase_price' => $price,
                    'current_price' => $price,
                    'total_value' => $total,
                    'profit_loss' => 0,
                    'profit_loss_percentage' => 0,
                ]);
            }
        } else {
            // Sell transaction
            $wallet = Wallet::where('user_id', $user->id)
                ->where('crypto_symbol', $request->crypto_symbol)
                ->first();

            if (!$wallet || $wallet->amount < $request->amount) {
                return response()->json([
                    'message' => 'Insufficient cryptocurrency holdings',
                ], 400);
            }

            // Update wallet
            $wallet->amount -= $request->amount;
            if ($wallet->amount <= 0) {
                $wallet->delete();
            } else {
                $wallet->current_price = $price;
                $wallet->total_value = $wallet->amount * $price;
                $wallet->profit_loss = $wallet->total_value - ($wallet->amount * $wallet->average_purchase_price);
                $wallet->profit_loss_percentage = $wallet->average_purchase_price > 0
                    ? (($wallet->profit_loss / ($wallet->amount * $wallet->average_purchase_price)) * 100)
                    : 0;
                $wallet->save();
            }

            // Add balance
            $user->balance += $total;
            $user->save();
        }

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'crypto_symbol' => $request->crypto_symbol,
            'crypto_name' => $crypto->name,
            'amount' => $request->amount,
            'price' => $price,
            'total' => $total,
            'status' => 'completed',
            'purchase_date' => now(),
        ]);

        return response()->json([
            'message' => 'Transaction completed successfully',
            'transaction' => $transaction,
            'new_balance' => $user->balance,
        ], 201);
    }

    /**
     * Get transaction statistics
     */
    public function statistics(Request $request)
    {
        $userId = $request->user()->id;

        $totalTransactions = Transaction::where('user_id', $userId)->count();
        $totalBuy = Transaction::where('user_id', $userId)
            ->where('type', 'buy')
            ->sum('total');
        $totalSell = Transaction::where('user_id', $userId)
            ->where('type', 'sell')
            ->sum('total');

        return response()->json([
            'total_transactions' => $totalTransactions,
            'total_buy' => $totalBuy,
            'total_sell' => $totalSell,
            'net_investment' => $totalBuy - $totalSell,
        ]);
    }
}

