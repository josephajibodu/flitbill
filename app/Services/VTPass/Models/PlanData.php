<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class PlanData implements Arrayable
{
    public function __construct(
        public string $variationCode,
        public string $name,
        public string $variationAmount,
        public string $fixedPrice
    ) {}

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'variationCode' => $this->variationCode,
            'name' => $this->name,
            'variationAmount' => $this->variationAmount,
            'fixedPrice' => $this->fixedPrice,
        ];
    }

    /**
     * Create an instance of PlanData from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['variationCode'] ?? $data['variation_code'] ?? '',
            $data['name'] ?? '',
            $data['variationAmount'] ?? $data['variation_amount'] ?? '',
            $data['fixedPrice'] ?? ''
        );
    }
}