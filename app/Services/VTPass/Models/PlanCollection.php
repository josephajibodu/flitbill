<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

class PlanCollection implements Arrayable
{
    /** @var PlanData[] */
    public array $plans;

    public function __construct(array $plans)
    {
        foreach ($plans as $plan) {
            if (!$plan instanceof PlanData) {
                throw new InvalidArgumentException("Each item in PlanDataCollection must be an instance of PlanData.");
            }
        }
        $this->plans = $plans;
    }

    /**
     * Convert the collection to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(fn (PlanData $plan) => $plan->toArray(), $this->plans);
    }

    /**
     * Create an instance of PlanDataCollection from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            array_map(fn ($plan) => PlanData::fromArray($plan), $data)
        );
    }
}