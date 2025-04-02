<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\DataTopup */
class DataTopupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'reference' => $this->reference,
            'amount' => $this->amount,
            'network' => $this->network,
            'phone_number' => $this->phone_number,
            'plan' => $this->plan,
            'service' => $this->service,
            'metadata' => $this->metadata,
            'status' => $this->status,

            'user_id' => $this->user_id,
            'transaction_id' => $this->transaction_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
        ];
    }
}
