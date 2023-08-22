<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('create', Category::class);

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
        $category = Category::query()->findOrFail($id);

        Gate::authorize('update', $category);

        $category->fill($request->validated());
        $category->save();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function destroy(string $id): JsonResponse
    {
        $category = Category::query()->findOrFail($id);

        Gate::authorize('delete', $category);

        $category->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
