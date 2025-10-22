<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


use App\Models\Image;
use App\Models\User;

class ImagePolicy
{

    use HandlesAuthorization;

    public function show(?User $user, Image $image): bool 
    {

        // TODO: inherit album hidden status
        if($image->is_hidden === 1) {
            if($user === null) {
                return false;
            }

            if($user !== null && $user->id !== $image->publisher_id) {
                return false;
            }
        }

        return true;
    }
    public function update(User $user, Image $image): bool
    {
        return $user->id === $image->publisher_id;
    }

    public function delete(User $user, Image $image): bool
    {
        return $user->id === $image->publisher_id;
    }
}
