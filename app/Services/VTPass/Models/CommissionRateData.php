<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class CommissionRateData implements Arrayable
{
    public function __construct(
        public float $amount,
        public string $rate,
        public string $rateType,
        public string $computationType
    ) {}

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'rate' => $this->rate,
            'rate_type' => $this->rateType,
            'computation_type' => $this->computationType,
        ];
    }

    /**
     * Create an instance of CommissionRateData from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['amount'] ?? 0.0,
            $data['rate'] ?? '',
            $data['rate_type'] ?? '',
            $data['computation_type'] ?? ''
        );
    }
}