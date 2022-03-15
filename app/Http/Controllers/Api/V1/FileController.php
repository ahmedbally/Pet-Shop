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
     * @param File $file
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(File $file): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (!Storage::exists($file->path))
            throw new NotFoundHttpException('File not found');
        return Storage::download($file->path, basename($file->path));
    }
}
