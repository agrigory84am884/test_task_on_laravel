<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Events\PostCreated;
use App\Models\Subscription;
use App\Jobs\SendNewPostEmail;
use App\Http\Requests\PostRequest;
use App\Jobs\SendEmailsForNewPostsJob;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json($posts);
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated());
        event(new PostCreated($post));
        return response()->json($post, 201);
    }

    /**
     * Display the specified post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
        */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json($post);
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return response()->json(null, 204);
    }
}