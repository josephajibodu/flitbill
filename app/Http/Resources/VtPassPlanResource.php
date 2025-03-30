<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\VtPassPlan */
class VtPassPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'service' => $this->service,
            'code' => $this->code,
            'amount' => $this->amount,
            'name' => $this->name,
            'duration_type' => $this->duration_type,
            'duration' => $this->duration,
            'size' => $this->size,
            'size_type' => $this->size_type,
        ];
    }
}
