<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->success();
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'path' => Storage::url($this->path),
            'size' => $this->size,
            'created_at' => $this->created_at,
            'updated_at' => $this->update_at,
        ];
    }
}
