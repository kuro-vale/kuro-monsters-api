<?php

namespace App\Policies;

use App\Models\Monster;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonsterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Monster $monster)
    {
        return $user->id == $monster->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Monster $monster)
    {
        return $user->id == $monster->user_id;
    }
}
