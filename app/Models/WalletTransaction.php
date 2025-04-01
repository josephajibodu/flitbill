<?php

namespace App\Models;

use App\Enums\WalletTransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'source',
        'destination',
        'type',
        'reason',
        'amount',
        'status',
        'expires_at'
    ];

    protected function casts(): array
    {
        return [
            'status' => WalletTransactionStatus::class
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
