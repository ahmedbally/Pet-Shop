<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\JsonResource;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     * path="/api/v1/brands",
     * operationId="allBrands",
     * tags={"Brands"},
     * summary="List all Brands",
     * description="List all Brands",
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
     *          description="User logout",
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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $sortBy = $request->input('sortBy');
        $isDesc = $request->boolean('desc', false);

        return Brand::query()->sort($sortBy, $isDesc)->paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     * path="/api/v1/brand/create",
     * operationId="CreateBrand",
     * security={{"bearer_token": {}}},
     * tags={"Brands"},
     * summary="Create Brand",
     * description="Create new Brand",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"title"},
     *               @OA\Property(property="title", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Category created successfully",
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
     * @param  \App\Http\Requests\StoreBrandRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create($request->safe()->all());

        return BrandResource::make($brand)->success()->response();
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     * path="/api/v1/brand/{uuid}",
     * operationId="singleBrand",
     * tags={"Brands"},
     * summary="Display fetched brand",
     * description="Display fetched brand",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Display fetched brand",
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Brand $brand)
    {
        return BrandResource::make($brand)->success()->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     * path="/api/v1/brand/{uuid}",
     * operationId="updateBrand",
     * security={{"bearer_token": {}}},
     * tags={"Brands"},
     * summary="Update brand with uuid",
     * description="Update a Brand",
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
     *               required={"title"},
     *               @OA\Property(property="title", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Brand updated successfully",
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
     * @param  \App\Http\Requests\UpdateBrandRequest  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->safe()->all());

        return BrandResource::make($brand)->success()->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     * path="/api/v1/brand/{uuid}",
     * operationId="deleteBrand",
     * security={{"bearer_token": {}}},
     * tags={"Brands"},
     * summary="Delete specific brand",
     * description="Delete specific brand",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Brand deleted successfully",
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Brand $brand)
    {
        if (! $brand->delete()) {
            return JsonResource::make([])->error('Unable to delete')->status(403)->response();
        }

        return JsonResource::make([])->success()->status(200)->response();
    }
}
