<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Crypto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PriceHistoryController extends Controller
{
    /**
     * Get price history for a cryptocurrency (30 days)
     */
    public function show(Request $request, $symbol)
    {
        $crypto = Crypto::where('symbol', strtoupper($symbol))->first();

        if (!$crypto) {
            return response()->json([
                'message' => 'Cryptocurrency not found',
            ], 404);
        }

        // Get last 30 days of price history
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $priceHistory = PriceHistory::where('crypto_symbol', strtoupper($symbol))
            ->where('date', '>=', $thirtyDaysAgo)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json([
            'crypto' => $crypto,
            'price_history' => $priceHistory,
        ]);
    }

    /**
     * Get price history for all cryptocurrencies (30 days)
     */
    public function index(Request $request)
    {
        $cryptos = Crypto::all();
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $history = [];
        foreach ($cryptos as $crypto) {
            $priceHistory = PriceHistory::where('crypto_symbol', $crypto->symbol)
                ->where('date', '>=', $thirtyDaysAgo)
                ->orderBy('date', 'asc')
                ->get();

            $history[$crypto->symbol] = [
                'crypto' => $crypto,
                'price_history' => $priceHistory,
            ];
        }

        return response()->json($history);
    }
}

