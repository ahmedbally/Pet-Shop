<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

/**
 * Class FileResourceTest.
 *
 * @covers \App\Http\Resources\FileResource
 */
class FileResourceTest extends TestCase
{
    /**
     * @var FileResource
     */
    protected $fileResource;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->fileResource = FileResource::make(File::factory()->create());
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fileResource);
    }

    public function test_to_array(): void
    {
        $request = Mockery::mock(Request::class);
        $keys = ['uuid', 'name', 'path', 'size', 'created_at', 'updated_at'];
        $resource = $this->fileResource->toArray($request);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $resource);
        }
    }
}
