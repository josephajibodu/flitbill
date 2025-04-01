<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\VtPassPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'banned_at' => $this->banned_at,
            'banned_reason' => $this->banned_reason
        ];
    }
}
