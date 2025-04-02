<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Airtime */
class AirtimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'amount' => $this->amount,
            'network' => $this->network,
            'phone_number' => $this->phone_number,
            'reference' => $this->reference,
            'service' => $this->service,
            'metadata' => $this->metadata,

            'user_id' => $this->user_id,

            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
