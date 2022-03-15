<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
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
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCategoryUuid($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereMetadata($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Builder
 * @method static Builder|Product sort($column, $isDesc)
 */
class Product extends Model
{
    use HasFactory, Uuidable, SoftDeletes, Sortable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'price',
        'description',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'price' => 'float',
        'metadata' => 'json',
        'deleted_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'metadata->brand');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class, 'metadata->image');
    }
}
