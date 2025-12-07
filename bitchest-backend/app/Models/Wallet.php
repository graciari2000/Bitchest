<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Wallet extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'wallets';

    protected $fillable = [
        'user_id',
        'crypto_symbol',
        'crypto_name',
        'amount',
        'average_purchase_price',
        'current_price',
        'total_value',
        'profit_loss',
        'profit_loss_percentage',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:8',
            'average_purchase_price' => 'decimal:2',
            'current_price' => 'decimal:2',
            'total_value' => 'decimal:2',
            'profit_loss' => 'decimal:2',
            'profit_loss_percentage' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get purchase history for this wallet entry.
     */
    public function purchaseHistory()
    {
        return $this->hasMany(Transaction::class, 'crypto_symbol', 'crypto_symbol')
            ->where('user_id', $this->user_id)
            ->where('type', 'buy')
            ->orderBy('created_at', 'desc');
    }
}

