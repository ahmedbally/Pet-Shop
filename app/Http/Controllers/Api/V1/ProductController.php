<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\JsonResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::query()->paginate();

        return ProductResource::collection($products)->success()->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product($request->safe()->except(['category', 'brand', 'image']));
        $product->category()->associate($request->input('category'));
        $product->brand()->associate($request->input('brand'));
        $product->image()->associate($request->input('image'));
        $product->save();

        return ProductResource::make($product)->success()->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return ProductResource::make($product)->success()->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->safe()->except('category', 'brand', 'image'));
        $product->category()->associate($request->input('category'));
        $product->brand()->associate($request->input('brand'));
        $product->image()->associate($request->input('image'));
        $product->save();

        return ProductResource::make($product)->success()->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        if (! $product->delete()) {
            return JsonResource::make([])->error('Unable to delete')->status(403)->response();
        }

        return JsonResource::make([])->success()->status(202)->response();
    }
}
