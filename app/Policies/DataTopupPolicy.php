<?php

namespace App\Policies;

use App\Models\DataTopup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataTopupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        
    }

    public function view(User $user, DataTopup $dataTopup): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, DataTopup $dataTopup): bool
    {
    }

    public function delete(User $user, DataTopup $dataTopup): bool
    {
    }

    public function restore(User $user, DataTopup $dataTopup): bool
    {
    }

    public function forceDelete(User $user, DataTopup $dataTopup): bool
    {
    }
}
