<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $file = $request->file('file');

        $path = $file->storePublicly('pet-shop');

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(File $file)
    {
        return FileResource::make($file)->response();
    }
}
