<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryApiResource;
use App\Http\Resources\Post\PostApiResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::oldest()->get();

        return response()->json([
            'success' => true,
            'data' => CategoryApiResource::collection($categories),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    public function posts(Category $category){
        $posts = $category->posts;

        return response()->json([
            'success' => true,
            'data' => [
                'category' => new CategoryApiResource($category),
                'posts' => PostApiResource::collection($posts)
            ],
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $inputs = $request->validated();

        $category = Category::create($inputs);

        return response()->json([
            'success' => true,
            'data' => new CategoryApiResource($category),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'success' => true,
            'data' => new CategoryApiResource($category),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $inputs = $request->validated();

        $result = $category->update($inputs);

        return response()->json([
            'success' => true,
            'data' => new CategoryApiResource($category->refresh()),
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $result = $category->delete();

        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'عملیات با موفقیت انجام شد'
        ]);
    }
}
