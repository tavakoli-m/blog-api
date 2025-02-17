<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostApiResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::oldest()->get();

        return response()->json([
            'success' => true,
            'data' => PostApiResource::collection($posts),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $inputs = $request->validated();

        $inputs['image'] = $request->file('image')->store('images','public');

        $post = Post::create($inputs);

        return response()->json([
            'success' => true,
            'data' => new PostApiResource($post),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'success' => true,
            'data' => new PostApiResource($post),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $inputs = $request->validated();

        if($request->hasFile('image')){
            Storage::disk('public')->delete($post->image);
            $inputs['image'] = $request->file('image')->store('images','public');
        }

        $result = $post->update($inputs);

        
        return response()->json([
            'success' => true,
            'data' => new PostApiResource($post->refresh()),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Storage::disk('public')->delete($post->image);

        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }
}
