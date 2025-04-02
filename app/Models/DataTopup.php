<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataTopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'user_id',
        'transaction_id',
        'amount',
        'network',
        'phone_number',
        'plan',
        'service',
        'metadata',
        'status',
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
