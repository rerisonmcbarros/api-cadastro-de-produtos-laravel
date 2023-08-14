<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::query()->with('products')->paginate(15)
        );
    }

    public function store(StoreCategoryRequest $request): CategoryResource
    {   
        $category = Category::query()->create($request->validated());
        return new CategoryResource($category);
    }

    public function show(string $id)
    {
        return new CategoryResource(
            Category::query()->with('products')->findOrFail($id)
        );
    }

    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        Category::query()->findOrFail($id)
        ->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function destroy(string $id): JsonResponse
    {
        Category::query()->findOrFail($id)
        ->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
