<?php

namespace App\Http\Controllers\V1\Admin;

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Category\DeleteCategoryRequest;
use App\Http\Requests\V1\Admin\Category\IndexCategoryRequest;
use App\Http\Requests\V1\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\V1\Admin\Category\UpdateCategoryRequest;
use App\Http\Resources\V1\Admin\Category\CategoryApiResource;
use App\Http\Resources\V1\Admin\Category\CategoryApiResourceCollection;
use App\Http\Resources\V1\Admin\Category\CategoryDetailApiResource;
use App\Http\Resources\V1\Admin\Category\CategoryListApiResourceCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCategoryRequest $request)
    {
        $result = app(Request::class)(function () {
            return Category::paginate(5);
        });

        return Response::withStatus(200)->withData(new CategoryApiResourceCollection($result->data))->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $result = app(Request::class)(function () use ($request) {
            return Category::create($request->validated());
        });

        return Response::withStatus(200)->withData(new CategoryApiResource($result->data))->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $result = app(Request::class)(function () use ($category) {
            return $category;
        });

        return Response::withStatus(200)->withData(new CategoryDetailApiResource($result->data))->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $result = app(Request::class)(function () use ($request,$category) {
            $category->update($request->validated());
            return $category;
        });

        return Response::withStatus(200)->withData(new CategoryApiResource($result->data))->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCategoryRequest $request,Category $category)
    {
        $result = app(Request::class)(function () use ($category) {
            return $category->delete();
        });

        return Response::withStatus(200)->withData($result->data)->send();
    }
}
