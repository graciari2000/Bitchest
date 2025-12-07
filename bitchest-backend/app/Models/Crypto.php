<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Crypto extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cryptos';

    protected $fillable = [
        'symbol',
        'name',
        'current_price',
        'price_change_24h',
        'price_change_percentage_24h',
        'market_cap',
        'volume_24h',
        'last_updated',
    ];

    protected function casts(): array
    {
        return [
            'current_price' => 'decimal:2',
            'price_change_24h' => 'decimal:2',
            'price_change_percentage_24h' => 'decimal:2',
            'market_cap' => 'decimal:2',
            'volume_24h' => 'decimal:2',
            'last_updated' => 'datetime',
        ];
    }
}
