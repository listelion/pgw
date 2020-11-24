<?php

namespace App\Policies;

use App\User;
use App\Finder;
use Illuminate\Auth\Access\HandlesAuthorization;

class FinderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        return $user->id === $finder->user_id;
    }
}
