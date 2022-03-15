<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\JsonResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     * path="/api/v1/products",
     * operationId="allProducts",
     * tags={"Products"},
     * summary="Show all products",
     * description="Show all products",
     *      @OA\Parameter(
     *           name="page",
     *           in="query",
     *           @OA\Schema(
     *           type="integer"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="limit",
     *           in="query",
     *           @OA\Schema(
     *           type="integer"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="sortBy",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="desc",
     *           in="query",
     *           @OA\Schema(
     *           type="boolean"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Products listed successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $sortBy = $request->input('sortBy');
        $isDesc = $request->boolean('desc', false);

        return Product::query()->sort($sortBy, $isDesc)->paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     * path="/api/v1/product/create",
     * operationId="CreateProduct",
     * security={{"bearer_token": {}}},
     * tags={"Products"},
     * summary="Create Product",
     * description="Create new Product",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"category_uuid", "title", "price", "description", "image", "brand"},
     *               @OA\Property(property="category_uuid", type="text"),
     *               @OA\Property(property="title", type="text"),
     *               @OA\Property(property="price", type="number"),
     *               @OA\Property(property="description", type="text"),
     *               @OA\Property(property="image", type="text"),
     *               @OA\Property(property="brand", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Product created successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product($request->safe()->except(['category_uuid', 'brand', 'image']));
        $product->category()->associate($request->input('category_uuid'));
        $product->brand()->associate($request->input('brand'));
        $product->image()->associate($request->input('image'));
        $product->save();

        return ProductResource::make($product)->success()->response();
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     * path="/api/v1/product/{uuid}",
     * operationId="singleProduct",
     * tags={"Products"},
     * summary="Display fetched product",
     * description="Display fetched product",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Display fetched product",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
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
     * @OA\Put(
     * path="/api/v1/product/{uuid}",
     * operationId="updateProduct",
     * security={{"bearer_token": {}}},
     * tags={"Products"},
     * summary="Update product with uuid",
     * description="update Product",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"category_uuid", "title", "price", "description", "image", "brand"},
     *               @OA\Property(property="category_uuid", type="text"),
     *               @OA\Property(property="title", type="text"),
     *               @OA\Property(property="price", type="number"),
     *               @OA\Property(property="description", type="text"),
     *               @OA\Property(property="image", type="text"),
     *               @OA\Property(property="brand", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Product updated successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->safe()->except('category_uuid', 'brand', 'image'));
        $product->category()->associate($request->input('category_uuid'));
        $product->brand()->associate($request->input('brand'));
        $product->image()->associate($request->input('image'));
        $product->save();

        return ProductResource::make($product)->success()->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     * path="/api/v1/product/{uuid}",
     * operationId="deleteProduct",
     * security={{"bearer_token": {}}},
     * tags={"Products"},
     * summary="Delete specific product",
     * description="Delete specific product",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Product deleted successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        if (! $product->delete()) {
            return JsonResource::make([])->error('Unable to delete')->status(403)->response();
        }

        return JsonResource::make([])->success()->status(200)->response();
    }
}
