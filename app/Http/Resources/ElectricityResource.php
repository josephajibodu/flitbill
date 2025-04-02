<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Electricity */
class ElectricityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'reference' => $this->reference,
            'amount' => $this->amount,
            'meter_number' => $this->meter_number,
            'provider' => $this->provider,
            'service' => $this->service,
            'meter_type' => $this->meter_type,
            'token' => $this->token,
            'status' => $this->status,
            'metadata' => $this->metadata,

            'user_id' => $this->user_id,
            'transaction_id' => $this->transaction_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
        ];
    }
}
