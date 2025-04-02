<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Airtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'reference',
        'amount',
        'network',
        'phone_number',
        'service',
        'status',
        'metadata',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
