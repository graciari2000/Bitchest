<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PriceHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'price_history';

    protected $fillable = [
        'crypto_symbol',
        'price',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'date' => 'date',
        ];
    }

    /**
     * Get the crypto that owns the price history.
     */
    public function crypto()
    {
        return $this->belongsTo(Crypto::class, 'crypto_symbol', 'symbol');
    }
}

