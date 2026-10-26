<?php

namespace App\Http\Controllers\V1\Admin;

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Post\CategoryListRequest;
use App\Http\Requests\V1\Admin\Post\ChangeStatusRequest;
use App\Http\Requests\V1\Admin\Post\DeletePostRequest;
use App\Http\Requests\V1\Admin\Post\IndexPostRequest;
use App\Http\Requests\V1\Admin\Post\ShowPostRequest;
use App\Http\Requests\V1\Admin\Post\StorePostRequest;
use App\Http\Requests\V1\Admin\Post\UpdatePostRequest;
use App\Http\Resources\V1\Admin\Post\CategoryListApiResource;
use App\Http\Resources\V1\Admin\Post\PostApiResource;
use App\Http\Resources\V1\Admin\Post\PostApiResourceCollection;
use App\Http\Resources\V1\Admin\Post\PostDetailApiResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPostRequest $request)
    {
        $result = app(Request::class)(function () {
            return Post::paginate(5);
        });

        return Response::withStatus(200)->withData(new PostApiResourceCollection($result->data))->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $result = app(Request::class)(function () use ($request) {
            $imageName = time().'_'.str_replace(' ', '_', $request->file('image')->getClientOriginalName());
            $image = $request->file('image')->move(public_path('images'), $imageName);

            $inputs = $request->validated();

            if ($image) {
                $inputs['image'] = $imageName;
            } else {
                return false;
            }

            $inputs['author_id'] = User::first()->id;

            if ($request->has('published_at')) {
                $inputs['published_at'] = substr($inputs['published_at'], 0, 10);
                $inputs['published_at'] = date('Y-m-d H:i:s', $inputs['published_at']);
            }

            return Post::create($inputs);
        });

        if (! $result->data) {
            return Response::withStatus(503)->withMessage('Failed To Save Image')->send();
        }

        return Response::withStatus(200)->withData(new PostApiResource($result->data))->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowPostRequest $request, Post $post)
    {
        $result = app(Request::class)(function () use ($post) {
            return $post;
        });

        return Response::withStatus(200)->withData(new PostDetailApiResource($result->data))->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $result = app(Request::class)(function () use ($request, $post) {
            $inputs = $request->validated();

            if ($request->has('image')) {

                $fileDeleteResult = File::delete(public_path('images/'.$post->image));

                if (! $fileDeleteResult) {
                    return false;
                }

                $imageName = time().'_'.str_replace(' ', '_', $request->file('image')->getClientOriginalName());
                $image = $request->file('image')->move(public_path('images'), $imageName);

                if ($image) {
                    $inputs['image'] = $imageName;
                } else {
                    return false;
                }
            }

            if ($request->has('published_at')) {
                $inputs['published_at'] = substr($inputs['published_at'], 0, 10);
                $inputs['published_at'] = date('Y-m-d H:i:s', $inputs['published_at']);
            }

            $post->update($inputs);

            return $post;
        });

        if (! $result->data) {
            return Response::withStatus(503)->withMessage('Failed To Save Image')->send();
        }

        return Response::withStatus(200)->withData(new PostApiResource($result->data))->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePostRequest $request, Post $post)
    {
        $result = app(Request::class)(function () use ($post) {
            $fileDeleteResult = File::delete(public_path('images/'.$post->image));

            return $fileDeleteResult && $post->delete();
        });

        return Response::withStatus(200)->withData($result->data)->send();
    }

    /**
     * change the specified resource from storage.
     */
    public function changeStatus(ChangeStatusRequest $request, Post $post)
    {
        $result = app(Request::class)(function () use ($post) {
            $post->update(['status' => $post->status == 1 ? 2 : 1]);

            return $post;
        });

        return Response::withStatus(200)->withData(new PostApiResource($result->data))->send();
    }

    public function categories(CategoryListRequest $request)
    {

        $result = app(Request::class)(function () {
            return Category::all();
        });

        return Response::withStatus(200)->withData(CategoryListApiResource::collection($result->data))->send();
    }
}
