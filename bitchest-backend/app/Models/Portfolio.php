<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Portfolio extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'portfolios';

    protected $fillable = [
        'user_id',
        'crypto_symbol',
        'crypto_name',
        'amount',
        'average_price',
        'current_price',
        'total_value',
        'profit_loss',
        'profit_loss_percentage',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:8',
            'average_price' => 'decimal:2',
            'current_price' => 'decimal:2',
            'total_value' => 'decimal:2',
            'profit_loss' => 'decimal:2',
            'profit_loss_percentage' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the portfolio.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
