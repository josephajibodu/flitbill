<?php

namespace App\Policies;

use App\Models\Cable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        
    }

    public function view(User $user, Cable $cable): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Cable $cable): bool
    {
    }

    public function delete(User $user, Cable $cable): bool
    {
    }

    public function restore(User $user, Cable $cable): bool
    {
    }

    public function forceDelete(User $user, Cable $cable): bool
    {
    }
}
