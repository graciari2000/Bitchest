<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    /**
     * Get user's portfolio
     */
    public function index(Request $request)
    {
        $portfolios = Portfolio::where('user_id', $request->user()->id)
            ->get()
            ->map(function ($portfolio) {
                // Update current price from crypto table
                $crypto = Crypto::where('symbol', $portfolio->crypto_symbol)->first();
                if ($crypto) {
                    $portfolio->current_price = $crypto->current_price;
                    $portfolio->total_value = $portfolio->amount * $crypto->current_price;
                    $portfolio->profit_loss = $portfolio->total_value - ($portfolio->amount * $portfolio->average_price);
                    $portfolio->profit_loss_percentage = $portfolio->average_price > 0 
                        ? (($portfolio->profit_loss / ($portfolio->amount * $portfolio->average_price)) * 100)
                        : 0;
                    $portfolio->save();
                }
                return $portfolio;
            });

        $totalValue = $portfolios->sum('total_value');
        $totalProfitLoss = $portfolios->sum('profit_loss');

        return response()->json([
            'portfolios' => $portfolios,
            'total_value' => $totalValue,
            'total_profit_loss' => $totalProfitLoss,
            'total_profit_loss_percentage' => $totalValue > 0 ? (($totalProfitLoss / ($totalValue - $totalProfitLoss)) * 100) : 0,
        ]);
    }

    /**
     * Get portfolio summary
     */
    public function summary(Request $request)
    {
        $portfolios = Portfolio::where('user_id', $request->user()->id)->get();
        
        $totalValue = 0;
        $totalProfitLoss = 0;
        $totalInvested = 0;

        foreach ($portfolios as $portfolio) {
            $crypto = Crypto::where('symbol', $portfolio->crypto_symbol)->first();
            if ($crypto) {
                $currentValue = $portfolio->amount * $crypto->current_price;
                $invested = $portfolio->amount * $portfolio->average_price;
                $totalValue += $currentValue;
                $totalInvested += $invested;
                $totalProfitLoss += ($currentValue - $invested);
            }
        }

        return response()->json([
            'total_value' => round($totalValue, 2),
            'total_invested' => round($totalInvested, 2),
            'total_profit_loss' => round($totalProfitLoss, 2),
            'total_profit_loss_percentage' => $totalInvested > 0 
                ? round(($totalProfitLoss / $totalInvested) * 100, 2) 
                : 0,
            'holdings_count' => $portfolios->count(),
        ]);
    }
}

