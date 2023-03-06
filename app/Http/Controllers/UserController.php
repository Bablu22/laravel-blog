<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function ShowAvatarForm()
    {
        return view('profile_avatar');
    }

    public function StoreAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);

        $user = auth()->user();
        $filename = $user->id . '_' . uniqid() . '.jpg';
        $imageData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/' . $filename, $imageData);

        $oldAvatar = $user->avatar;
        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != 'fallback-avatar.jpg') {
            Storage::delete(str_replace('/storage/', 'public/', $oldAvatar));
        }

        return redirect()->back()->with('success', 'Profile photo upload success');
    }

    // Register an user
    public function register(Request $request): RedirectResponse
    {
        $userData = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account');
    }

    // Login user
    public function login(Request $request): RedirectResponse
    {
        $formData = $request->validate([
            'loginusername' => ['required', 'min:3', 'max:20',],
            'loginpassword' => ['required', 'min:8']
        ], [
            'loginusername.required' => 'Username is required',
            'loginusername.min' => 'Username is invalid',
            'loginusername.max' => 'Username is invalid',
            'loginpassword.required' => 'Password is required',
            'loginpassword.min' => 'Password is invalid'
        ]);

        if (auth()->attempt(['username' => $formData['loginusername'], 'password' => $formData['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', "You are logged in");
        } else {
            return redirect('/')->with('failure', "Invalid login credentials");
        }
    }

    // Logout an user
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/')->with('success', 'You are logged out');
    }

    private function sharedData($user)
    {
        $posts = $user->posts()->latest()->get();
        $count_post = count($posts);
        $currently_following = 0;
        if (auth()->check()) {
            $currently_following = Follow::where([['user_id', '=', auth()->user()->id], ['followedUser', '=', $user->id]])->count();
        }

        View::share('sharedData', ['currently_following' => $currently_following, 'avatar' => $user->avatar, 'username' => $user->username, 'count' => $count_post, 'followers' => $user->followers()->count(),'following' => $user->following()->count()]);
    }

    // Show profile
    public function profile(User $user)
    {
        $posts = $user->posts()->latest()->get();
        $this->sharedData($user);
        return view('profile', ['posts' => $posts]);
    }

    public function profileFollowers(User $user)
    {
        $this->sharedData($user);
        return view('followers', ['followers' => $user->followers()->latest()->get()]);
    }

    public function profileFollowing(User $user)
    {
        $this->sharedData($user);
        return view('following', ['following' => $user->following()->latest()->get()]);
    }
}


