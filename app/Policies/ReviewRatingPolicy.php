<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReviewRating;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewRatingPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, ReviewRating $reviewRating)
    {
        return $user->role === 'admin';
    }
}
