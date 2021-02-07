<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user)
    {
        $email = $user->email;
        $username = $user->username;
        if (!$username) {
            $username = str_replace('@', '.', $email);
        }

        $user->email = $email;
        $user->username = $username;
    }
}
