<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;


class ResourcePolicy
{
    
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function admin(User $user)
    {
        return $user->role->slug === 'admin';
    }

    public function employee(User $user)
    {
        return $user->role->slug === 'employee';
    }

    public function customer(User $user)
    {
        return $user->role->slug === 'customer';
    }


    public function noCustomer(User $user)
    {
        return $user->role->slug == 'admin';
    }
}
