<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;

class IsAdmin
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function All (User $user)
    {
        return $user->role === 'merchant' | $user->role === 'costumer';
    }

    public function Merchant (User $user)
    {
        return $user->role === 'merchant' ? Response::allow()
            : Response::deny('Hanya merchant yg dapat mengakses url ini');
    }

    public function Costumer (User $user)
    {
        return $user->role === 'costumer' ? Response::allow()
            : Response::deny('Hanya costumer yg dapat mengakses url ini');
    }
}
