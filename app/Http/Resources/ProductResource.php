<?php

namespace App\Http\Resources;

/**
 * @property string $uuid
 * @property string $category_uuid
 * @property string $title
 * @property float $price
 * @property string $description
 * @property array $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\File|null $image
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @phpstan-ignore-next-line
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'category_uuid' => $this->category_uuid,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'metadata' => [
                'brand' => $this->metadata['brand'],
                'image' => $this->metadata['image'],
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
