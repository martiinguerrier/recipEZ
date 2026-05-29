<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $auth = auth()->user();

        if ($auth->id === $user->id) {
            return back();
        }

        if ($auth->isFollowing($user)) {
            $auth->following()->detach($user->id);
        } else {
            $auth->following()->attach($user->id);
        }

        return back();
    }
}
