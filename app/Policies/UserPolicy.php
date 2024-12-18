<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // return (bool) $user->id === $model->id;
        return $user->is($model);
    }
}
