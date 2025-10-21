<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;

class ImagePolicy
{
    public function update(User $user, Image $image): bool
    {
        return $user->id === $image->publisher_id;
    }

    public function delete(User $user, Image $image): bool
    {
        return $user->id === $image->publisher_id;
    }
}
