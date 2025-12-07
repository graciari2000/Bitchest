<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'transactions';

    protected $fillable = [
        'user_id',
        'type', // 'buy' or 'sell'
        'crypto_symbol',
        'crypto_name',
        'amount',
        'price',
        'total',
        'status', // 'pending', 'completed', 'failed'
        'purchase_date',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:8',
            'price' => 'decimal:2',
            'total' => 'decimal:2',
            'purchase_date' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
