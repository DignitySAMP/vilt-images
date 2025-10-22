<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;

class AlbumPolicy
{
    public function show(?User $user, Album $album): bool 
    {
        if($album->is_hidden === 1) {
            if($user === null) {
                return false;
            }

            if($user->id !== $album->user_id) {
                return false;
            }
        }

        return true;
    }

    public function update(User $user, Album $album): bool
    {
        return $user->id === $album->user_id;
    }

    public function delete(User $user, Album $album): bool
    {
        return $user->id === $album->user_id;
    }
}
