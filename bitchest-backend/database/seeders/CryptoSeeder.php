<?php

namespace Database\Seeders;

use App\Models\Crypto;
use App\Models\PriceHistory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // The 10 specific cryptocurrencies required
        $cryptos = [
            [
                'symbol' => 'BTC',
                'name' => 'Bitcoin',
                'base_price' => 43250.00,
            ],
            [
                'symbol' => 'ETH',
                'name' => 'Ethereum',
                'base_price' => 2580.50,
            ],
            [
                'symbol' => 'XRP',
                'name' => 'Ripple',
                'base_price' => 0.62,
            ],
            [
                'symbol' => 'BCH',
                'name' => 'Bitcoin Cash',
                'base_price' => 245.30,
            ],
            [
                'symbol' => 'ADA',
                'name' => 'Cardano',
                'base_price' => 0.52,
            ],
            [
                'symbol' => 'LTC',
                'name' => 'Litecoin',
                'base_price' => 74.85,
            ],
            [
                'symbol' => 'XEM',
                'name' => 'NEM',
                'base_price' => 0.038,
            ],
            [
                'symbol' => 'XLM',
                'name' => 'Stellar',
                'base_price' => 0.12,
            ],
            [
                'symbol' => 'IOTA',
                'name' => 'IOTA',
                'base_price' => 0.25,
            ],
            [
                'symbol' => 'DASH',
                'name' => 'Dash',
                'base_price' => 28.50,
            ],
        ];

        foreach ($cryptos as $cryptoData) {
            // Create or update crypto
            $crypto = Crypto::updateOrCreate(
                ['symbol' => $cryptoData['symbol']],
                [
                    'name' => $cryptoData['name'],
                    'current_price' => $cryptoData['base_price'],
                    'price_change_24h' => 0,
                    'price_change_percentage_24h' => 0,
                    'market_cap' => $cryptoData['base_price'] * 1000000, // Placeholder
                    'volume_24h' => $cryptoData['base_price'] * 10000, // Placeholder
                    'last_updated' => now(),
                ]
            );

            // Generate 30 days of historical price data
            $this->generatePriceHistory($crypto->symbol, $cryptoData['base_price']);
        }
    }

    /**
     * Generate 30 days of price history using realistic price variations
     */
    private function generatePriceHistory(string $symbol, float $basePrice): void
    {
        $startDate = Carbon::now()->subDays(30);
        $currentPrice = $basePrice;

        for ($day = 0; $day <= 30; $day++) {
            $date = $startDate->copy()->addDays($day);

            // Generate realistic price variation (-5% to +5% daily change)
            $variation = (rand(-500, 500) / 10000); // -5% to +5%
            $currentPrice = $currentPrice * (1 + $variation);

            // Ensure price doesn't go negative
            $currentPrice = max($currentPrice, $basePrice * 0.5);

            PriceHistory::updateOrCreate(
                [
                    'crypto_symbol' => $symbol,
                    'date' => $date->format('Y-m-d'),
                ],
                [
                    'price' => round($currentPrice, 2),
                ]
            );
        }

        // Update current price in crypto table with the latest generated price
        Crypto::where('symbol', $symbol)->update([
            'current_price' => round($currentPrice, 2),
            'price_change_24h' => round($currentPrice - $basePrice, 2),
            'price_change_percentage_24h' => round((($currentPrice - $basePrice) / $basePrice) * 100, 2),
        ]);
    }
}
