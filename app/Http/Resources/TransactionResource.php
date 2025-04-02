<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Transaction */
class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'reference' => $this->reference,
            'description' => $this->description,
            'type' => $this->type,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'status' => $this->status,
            'commission' => $this->commission,
            'metadata' => $this->metadata,

            'user_id' => $this->user_id,

            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
