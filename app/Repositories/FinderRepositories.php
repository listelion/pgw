<?php

namespace App\Repositories;

use App\User;

class FinderRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return $user->finders()
            ->orderBy('created_at', 'asc')
            ->get();
    }
}