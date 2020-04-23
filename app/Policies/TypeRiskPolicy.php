<?php

namespace App\Policies;

use App\User;
use App\TypeRisk;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypeRiskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the type risk.
     *
     * @param  \App\User  $user
     * @param  \App\TypeRisk  $typeRisk
     * @return mixed
     */

    public function view(User $user, TypeRisk $typeRisk)
    {
        //
    }

    /**
     * Determine whether the user can create type risks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      switch($user->user_level->user_id)
      {
        case 1: return true; break;
        case 2: return true; break;
        case 3: return true; break;
        case 4: return false; break;
        case 5: return false; break;
        default : return false; break;
      }
    }

    /**
     * Determine whether the user can update the type risk.
     *
     * @param  \App\User  $user
     * @param  \App\TypeRisk  $typeRisk
     * @return mixed
     */
    public function update(User $user, TypeRisk $typeRisk)
    {
        //
    }

    /**
     * Determine whether the user can delete the type risk.
     *
     * @param  \App\User  $user
     * @param  \App\TypeRisk  $typeRisk
     * @return mixed
     */
    public function delete(User $user, TypeRisk $typeRisk)
    {
        //
    }

    /**
     * Determine whether the user can restore the type risk.
     *
     * @param  \App\User  $user
     * @param  \App\TypeRisk  $typeRisk
     * @return mixed
     */
    public function restore(User $user, TypeRisk $typeRisk)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the type risk.
     *
     * @param  \App\User  $user
     * @param  \App\TypeRisk  $typeRisk
     * @return mixed
     */
    public function forceDelete(User $user, TypeRisk $typeRisk)
    {
        //
    }
}
