<?php

namespace App\Models;

use App\Enums\DurationType;
use App\Enums\SizeUnit;
use Illuminate\Database\Eloquent\Model;

class VtPassPlan extends Model
{
    protected $fillable = [
        'service',
        'code',
        'amount',
        'name',
        'label',
        'duration_type',
        'duration',
        'size',
        'size_unit',
        'extras',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'duration_type' => DurationType::class,
            'size_unit' => SizeUnit::class
        ];
    }
}
