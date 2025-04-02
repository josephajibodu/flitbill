<?php

namespace App\Policies;

use App\Models\Electricity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ElectricityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        
    }

    public function view(User $user, Electricity $electricity): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Electricity $electricity): bool
    {
    }

    public function delete(User $user, Electricity $electricity): bool
    {
    }

    public function restore(User $user, Electricity $electricity): bool
    {
    }

    public function forceDelete(User $user, Electricity $electricity): bool
    {
    }
}
