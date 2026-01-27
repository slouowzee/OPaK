<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $user->id) {
            return back();
        }

        if ($currentUser->isFollowing($user)) {
            $currentUser->followings()->detach($user->id);
        } else {
            $currentUser->followings()->attach($user->id);
        }

        return back();
    }
}
