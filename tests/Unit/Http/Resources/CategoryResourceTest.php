<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

/**
 * Class CategoryResourceTest.
 *
 * @covers \App\Http\Resources\CategoryResource
 */
class CategoryResourceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $category = Category::factory()->create();
        $this->categoryResource = CategoryResource::make($category);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->categoryResource);
    }

    public function test_to_array(): void
    {
        $request = Mockery::mock(Request::class);
        $keys = ['uuid', 'title', 'slug', 'created_at', 'updated_at'];
        $resource = $this->categoryResource->toArray($request);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $resource);
        }
    }
}
