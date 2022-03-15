<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     * path="/api/v1/file/upload",
     * operationId="uploadFile",
     * security={{"bearer_token": {}}},
     * tags={"File"},
     * summary="File Upload",
     * description="User can upload file here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"file"},
     *               @OA\Property(property="file", type="file"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="File uploaded Successfully",
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        /**
         * @var UploadedFile $file
         */
        $file = $request->file('file');

        $path = $file->store('pet-shop');

        return FileResource::make(File::create([
            'name' => Str::random(16),
            'path' => $path,
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
        ]))->response();
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     * path="/api/v1/file/{uuid}",
     * operationId="downloadFile",
     * tags={"File"},
     * summary="User can download file",
     * description="User can download file",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="File downloaded successfully.",
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
     * @param File $file
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(File $file): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (! Storage::exists($file->path)) {
            throw new NotFoundHttpException('File not found');
        }

        return Storage::download($file->path, basename($file->path));
    }
}
