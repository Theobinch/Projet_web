<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user): bool
    {
        return $user->school()->pivot->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->school()->pivot->role === 'admin';
    }

    public function update(User $user): bool
    {
        return $user->school()->pivot->role === 'admin';
    }

    public function delete(User $user): bool
    {
        return $user->school()->pivot->role === 'admin';
    }
}
