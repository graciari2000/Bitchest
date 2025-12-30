<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Get all cryptocurrencies
     */
    public function index(Request $request)
    {
        $cryptos = Crypto::orderBy('market_cap', 'desc')->get();

        return response()->json([
            'cryptos' => $cryptos,
        ]);
    }

    /**
     * Get top cryptocurrencies
     */
    public function top(Request $request)
    {
        $limit = $request->get('limit', 10);
        $cryptos = Crypto::orderBy('market_cap', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'cryptos' => $cryptos,
        ]);
    }

    /**
     * Get specific cryptocurrency
     */
    public function show($symbol)
    {
        $crypto = Crypto::where('symbol', strtoupper($symbol))->first();

        if (!$crypto) {
            return response()->json([
                'message' => 'Cryptocurrency not found',
            ], 404);
        }

        return response()->json([
            'crypto' => $crypto,
        ]);
    }

    /**
     * Get market trends (top cryptocurrencies with price changes)
     */
    public function trends(Request $request)
    {
        $limit = $request->get('limit', 10);
        $cryptos = Crypto::orderBy('market_cap', 'desc')
            ->limit($limit)
            ->get();

        $trends = $cryptos->map(function ($crypto) {
            return [
                'symbol' => $crypto->symbol,
                'name' => $crypto->name,
                'price' => (float) $crypto->current_price,
                'change' => (float) ($crypto->price_change_percentage_24h ?? 0),
            ];
        });

        return response()->json($trends);
    }

    /**
     * Get market notifications (price alerts and market updates)
     */
    public function notifications(Request $request)
    {
        // Get cryptocurrencies with significant price changes (>= 5%)
        $significantChanges = Crypto::whereNotNull('price_change_percentage_24h')
            ->where(function ($query) {
                $query->where('price_change_percentage_24h', '>=', 5)
                      ->orWhere('price_change_percentage_24h', '<=', -5);
            })
            ->orderBy('market_cap', 'desc')
            ->limit(5)
            ->get();

        $notifications = collect();

        // Create price alert notifications for significant changes
        foreach ($significantChanges as $crypto) {
            $change = (float) ($crypto->price_change_percentage_24h ?? 0);
            $isPositive = $change > 0;
            
            $notifications->push([
                'id' => uniqid('notif_'),
                'type' => 'info',
                'title' => 'Price Alert',
                'message' => $crypto->symbol . ' is ' . ($isPositive ? 'up' : 'down') . ' ' . abs($change) . '% today',
                'amount' => (float) $crypto->current_price,
                'read' => false,
                'created_at' => now()->toISOString(),
            ]);
        }

        // If no significant changes, return empty array or default notifications
        if ($notifications->isEmpty()) {
            $notifications = collect([
                [
                    'id' => uniqid('notif_'),
                    'type' => 'info',
                    'title' => 'Market Update',
                    'message' => 'Market is stable today',
                    'read' => false,
                    'created_at' => now()->toISOString(),
                ],
            ]);
        }

        return response()->json($notifications->values()->all());
    }

    /**
     * Update cryptocurrency prices (for admin or scheduled job)
     */
    public function updatePrices(Request $request)
    {
        // This would typically be called by a scheduled job or external API
        // For now, we'll create a simple endpoint that can be called
        
        $request->validate([
            'prices' => 'required|array',
            'prices.*.symbol' => 'required|string',
            'prices.*.current_price' => 'required|numeric',
            'prices.*.price_change_24h' => 'nullable|numeric',
            'prices.*.price_change_percentage_24h' => 'nullable|numeric',
            'prices.*.market_cap' => 'nullable|numeric',
            'prices.*.volume_24h' => 'nullable|numeric',
        ]);

        foreach ($request->prices as $priceData) {
            Crypto::updateOrCreate(
                ['symbol' => strtoupper($priceData['symbol'])],
                [
                    'name' => $priceData['name'] ?? $priceData['symbol'],
                    'current_price' => $priceData['current_price'],
                    'price_change_24h' => $priceData['price_change_24h'] ?? 0,
                    'price_change_percentage_24h' => $priceData['price_change_percentage_24h'] ?? 0,
                    'market_cap' => $priceData['market_cap'] ?? 0,
                    'volume_24h' => $priceData['volume_24h'] ?? 0,
                    'last_updated' => now(),
                ]
            );
        }

        return response()->json([
            'message' => 'Prices updated successfully',
        ]);
    }
}

