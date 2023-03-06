<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\RedirectResponse;


class FollowController extends Controller
{
    public function createFollow(User $user): RedirectResponse
    {
        // You can not follow yourself
        if ($user->id == auth()->user()->id) {
            return redirect()->back()->with('failure', 'You can not follow yourself');
        }

        // You cannot follow someone already you are follow
        $alreadyFollowed = Follow::where([['user_id', '=', auth()->user()->id], ['followedUser', '=', $user->id]])->count();

        if ($alreadyFollowed) {
            return redirect()->back()->with('failure', 'You already followed this user');
        }

        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followedUser = $user->id;
        $newFollow->save();
        return redirect()->back()->with('success', 'You are following this user');
    }

    public function removeFollow(User $user): RedirectResponse
    {
        Follow::where([['user_id', '=', auth()->user()->id], ['followedUser', '=', $user->id]])->delete();
        return redirect()->back()->with('success', 'You are unfollow this user');
    }
}
