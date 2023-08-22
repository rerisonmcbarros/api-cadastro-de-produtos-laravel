<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductImageResource;
use App\Http\Requests\AddImageProductRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::query()->with(['category', 'images'])->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        Gate::authorize('create', Product::class);

        $product = Product::query()->create($request->except(['images']));

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {
            
                $image = new ProductImage();
                $image->product_id = $product->id;
                $image->path = $file->store("products/{$product->id}/images", 'public');
                $image->save();
    
                unset($image);
            }
        }

        return new ProductResource(
            $product
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): ProductResource
    {
        return new ProductResource(
            Product::query()->with(['category', 'images'])->findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $product = Product::query()->findOrFail($id);

        Gate::authorize('update', $product);

        $product->fill($request->validated());
        $product->save();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::query()->with('images')
        ->findOrFail($id);

        Gate::authorize('delete', $product);
        
        $product->delete();
        
        Storage::disk('public')->deleteDirectory("products/{$product->id}");
        
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function addImage(AddImageProductRequest $request, $id): ProductImageResource
    {
        Gate::authorize('addImage', Product::class);

        $product = Product::query()->with('images')->findOrFail($id);
        $image = $product->images()->create([
            "path" => $request->file('image')->store("products/{$product->id}/images", 'public')
        ]);

        return new ProductImageResource($image);
    }

    public function removeImage($id): JsonResponse
    {
        Gate::authorize('removeImage', Product::class);

        $image = ProductImage::query()->findOrFail($id);
        $image->delete();
        Storage::disk('public')->delete($image->path);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
