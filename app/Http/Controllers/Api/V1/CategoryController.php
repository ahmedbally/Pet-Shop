<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\JsonResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\ValidatedInput;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     * path="/api/v1/categories",
     * operationId="allCategories",
     * tags={"Categories"},
     * summary="List all Categories",
     * description="List all Categories",
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
     *          description="Categories listed successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
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

        return  Category::sort($sortBy, $isDesc)->paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     * path="/api/v1/category/create",
     * operationId="CreateCateogry",
     * security={{"bearer_token": {}}},
     * tags={"Categories"},
     * summary="Create Category",
     * description="Create new Category",
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
     *          description="Category created successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        /**
         * @var ValidatedInput $safeRequest
         */
        $safeRequest = $request->safe();
        $category = Category::create($safeRequest->all());

        return CategoryResource::make($category)->success()->response();
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     * path="/api/v1/category/{uuid}",
     * operationId="singleCategory",
     * tags={"Categories"},
     * summary="Display fetched category",
     * description="Display fetched category",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Display fetched category"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return CategoryResource::make($category)->success()->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     * path="/api/v1/category/{uuid}",
     * operationId="updateCategory",
     * security={{"bearer_token": {}}},
     * tags={"Categories"},
     * summary="Update category with uuid",
     * description="Update a Category",
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
     *          description="Category updated successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        /**
         * @var ValidatedInput $safeRequest
         */
        $safeRequest = $request->safe();
        $category->update($safeRequest->all());

        return CategoryResource::make($category)->success()->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     * path="/api/v1/category/{uuid}",
     * operationId="deleteCategory",
     * security={{"bearer_token": {}}},
     * tags={"Categories"},
     * summary="Delete specific category",
     * description="Delete specific category",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Brand deleted successfully"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        if (! $category->delete()) {
            return JsonResource::make([])->error('Unable to delete')->status(403)->response();
        }

        return JsonResource::make([])->success()->status(200)->response();
    }
}
