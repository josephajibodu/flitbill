<?php

namespace App\Policies;

use App\Models\Airtime;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AirtimePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        
    }

    public function view(User $user, Airtime $airtime): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Airtime $airtime): bool
    {
    }

    public function delete(User $user, Airtime $airtime): bool
    {
    }

    public function restore(User $user, Airtime $airtime): bool
    {
    }

    public function forceDelete(User $user, Airtime $airtime): bool
    {
    }
}
