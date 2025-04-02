<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Electricity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'reference',
        'amount',
        'meter_number',
        'provider',
        'service',
        'meter_type',
        'token',
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
