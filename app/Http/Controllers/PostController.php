<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewPostEmail;
use App\Mail\NewPostMail;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{
    public function create(): View
    {
        return view('create_post');
    }

    public function store(Request $request): RedirectResponse
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);


        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();


        $post = Post::create($incomingFields);

        dispatch(new SendNewPostEmail(['sendTo' => auth()->user()->email, 'name' => auth()->user()->username, 'title' => $post->title, 'id' => $post->id]));
        return redirect("/post/{$post->id}")->with('success', 'Post created success');
    }


    public function show(Post $post): View
    {
        $post['body'] = strip_tags(Str::markdown($post->body), '<p><ul><ol><li><strong><em><h3><br><h2><h1><h4><h5><h6>');
        return view('single-post', compact('post'));
    }

    public function edit(Post $post): View
    {
        return view('edit_post', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post = $post->update($incomingFields);
        return redirect()->back()->with('success', 'Post update success');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post delete success');
    }

    // Search post form database
    public function search($term)
    {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
}


